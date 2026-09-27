<?php

declare(strict_types=1);

namespace edrard\Tests\WotClient;

use edrard\WgGetter\Contracts\BatchTransportInterface;
use edrard\WgGetter\Contracts\RateLimiterInterface;
use edrard\WgGetter\Http\HttpResult;
use edrard\WgGetter\RetryPolicy;
use edrard\WgGetter\WgDataGetter;
use edrard\WotClient\Facades\Wot;
use edrard\WotClient\Http\DefaultRequestExecutor;
use edrard\WotClient\WotClient;
use PHPUnit\Framework\TestCase;

final class MultigetTest extends TestCase
{
    private function client(BatchTransportInterface $transport): WotClient
    {
        $limiter = new class () implements RateLimiterInterface {
            public function acquire(int $requests = 1): void
            {
            }
        };
        $getter = new WgDataGetter($transport, retry: new RetryPolicy(1), limiter: $limiter);
        return new WotClient('fixture', executor: new DefaultRequestExecutor(['eu' => 'fixture', 'na' => 'fixture', 'asia' => 'fixture'], getter: $getter));
    }

    public function testActualHttpConcurrencyAcrossChunksAndRealmsAndCompleteMerge(): void
    {
        $active = $peak = 0;
        $hosts = [];
        $handler = static function (\Psr\Http\Message\RequestInterface $request) use (&$active, &$peak, &$hosts): \GuzzleHttp\Promise\Promise {
            ++$active;
            $peak = max($peak, $active);
            $hosts[] = $request->getUri()->getHost();
            parse_str($request->getUri()->getQuery(), $parameters);
            $ids = array_map('intval', explode(',', $parameters['account_id']));
            $promise = null;
            $promise = new \GuzzleHttp\Promise\Promise(static function () use (&$promise, &$active, $ids): void {
                --$active;
                $promise->resolve(new \GuzzleHttp\Psr7\Response(200, [], json_encode(['status' => 'ok', 'data' => array_fill_keys($ids, null), 'meta' => ['count' => count($ids)]], JSON_THROW_ON_ERROR)));
            });
            return $promise;
        };
        $client = $this->client(new \edrard\WgGetter\Http\GuzzleTransport(new \GuzzleHttp\Client(['handler' => $handler])));
        $outcomes = $client->executeMany([
            'eu' => $client->accounts()->prepareInfo(range(1, 201)),
            'na' => $client->forRealm(\edrard\WgApi\Realm::NA)->accounts()->prepareInfo([500]),
        ], 2);
        self::assertTrue($outcomes['eu']->succeeded());
        self::assertSame(201, $outcomes['eu']->result()->count());
        self::assertSame(range(1, 201), array_keys($outcomes['eu']->result()->data()));
        self::assertCount(3, $outcomes['eu']->parts);
        self::assertSame([500 => null], $outcomes['na']->result()->data());
        self::assertSame(2, $peak);
        self::assertSame(0, $active);
        self::assertSame(['api.worldoftanks.eu', 'api.worldoftanks.eu', 'api.worldoftanks.eu', 'api.worldoftanks.com'], $hosts);
    }

    public function testForgedWriteIsRejectedBeforeSendingAnyValidSibling(): void
    {
        $transport = new class () implements BatchTransportInterface {
            public function send(array $urls, int $concurrency): array
            {
                TestCase::fail('No operation should have been sent.');
            }
        };
        $client = $this->client($transport);
        $token = new \edrard\WgAuth\AccessToken(\edrard\WgApi\Realm::EU, 1, 'fixture', time() + 3600);
        $write = new \edrard\WotClient\PreparedOperation(\edrard\WgApi\Realm::EU, 'stronghold/activateclanreserve', ['reserve_type' => 'BATTLE_PAYMENTS', 'reserve_level' => 1], $token);
        $this->expectException(\InvalidArgumentException::class);
        $client->executeMany([$client->accounts()->prepareInfo([1]), $write]);
    }

    public function testProviderChunksShareMultigetAndPartialFailureKeepsSuccessfulParts(): void
    {
        $transport = new class () implements BatchTransportInterface {
            public array $calls = [];
            public function send(array $urls, int $concurrency): array
            {
                $this->calls[] = [$urls, $concurrency];
                $results = [];
                foreach ($urls as $key => $url) {
                    parse_str(parse_url($url, PHP_URL_QUERY), $params);
                    $ids = array_map('intval', explode(',', $params['account_id']));
                    $results[$key] = min($ids) === 101 ? new HttpResult(404) : new HttpResult(200, json_encode(['status' => 'ok', 'data' => array_fill_keys($ids, null)], JSON_THROW_ON_ERROR));
                }
                return $results;
            }
        };
        $client = $this->client($transport);
        $ops = ['large' => $client->accounts()->prepareInfo(range(1, 101)), 'small' => $client->accounts()->prepareAchievements([7])];
        self::assertSame([], $transport->calls);
        $outcomes = $client->executeMany($ops, 2);
        self::assertSame(['large', 'small'], array_keys($outcomes));
        self::assertFalse($outcomes['large']->succeeded());
        self::assertCount(2, $outcomes['large']->parts);
        self::assertSame(100, $outcomes['large']->parts[0]->result()->count());
        self::assertSame(404, $outcomes['large']->parts[1]->failure->providerCode);
        self::assertTrue($outcomes['small']->succeeded());
        self::assertSame([7 => null], $outcomes['small']->result()->data());
        self::assertCount(2, $transport->calls);
        self::assertCount(2, $transport->calls[0][0]);
        self::assertSame(2, $transport->calls[0][1]);
        self::assertCount(1, $transport->calls[1][0]);
    }

    public function testWrongResponseIdentityFailsOnlyAffectedOperationAndStaticApiWorks(): void
    {
        $transport = new class () implements BatchTransportInterface {
            public function send(array $urls, int $concurrency): array
            {
                return [0 => new HttpResult(200, '{"status":"ok","data":{"999":null}}'), 1 => new HttpResult(200, '{"status":"ok","data":{"2":null}}')];
            }
        };
        $client = $this->client($transport);
        Wot::configure($client);
        try {
            $outcomes = Wot::executeMany(['bad' => Wot::accounts()->prepareInfo([1]), 'ok' => Wot::accounts()->prepareInfo([2])]);
            self::assertSame('invalid_response', $outcomes['bad']->failure->kind);
            self::assertSame([2 => null], $outcomes['ok']->result()->data());
        } finally {
            Wot::reset();
        }
    }

    public function testPrivateReadKeepsTokenOnHttpsWireButNotInFailureOrDebugOutput(): void
    {
        $transport = new class () implements BatchTransportInterface {
            public function send(array $urls, int $concurrency): array
            {
                parse_str(parse_url($urls[0], PHP_URL_QUERY), $parameters);
                TestCase::assertStringStartsWith('https://api.worldoftanks.eu/', $urls[0]);
                TestCase::assertSame('fixture-private-token', $parameters['access_token']);
                return [0 => new HttpResult(200, '{"status":"error","error":{"code":403,"message":"fixture-private-token"}}')];
            }
        };
        $client = $this->client($transport);
        $token = new \edrard\WgAuth\AccessToken(\edrard\WgApi\Realm::EU, 1, 'fixture-private-token', time() + 3600);
        $operation = $client->accounts()->prepareInfo([1], accessToken: $token);
        $outcome = $client->executeMany([$operation])[0];
        self::assertFalse($outcome->succeeded());
        self::assertSame(403, $outcome->failure->providerCode);
        ob_start();
        var_dump($operation, $outcome, $client);
        $debug = ob_get_clean();
        self::assertStringNotContainsString('fixture-private-token', $debug);
        self::assertStringNotContainsString('api.worldoftanks.eu', $debug);
    }

    public function testRateLimitOutcomeRetainsCooldownWithoutAddingClientRetries(): void
    {
        $transport = new class () implements BatchTransportInterface {
            public int $calls = 0;
            public function send(array $urls, int $concurrency): array
            {
                ++$this->calls;
                return [0 => new HttpResult(429, retryAfter: 60)];
            }
        };
        $client = $this->client($transport);
        $outcome = $client->executeMany([$client->accounts()->prepareInfo([1])])[0];
        self::assertSame(429, $outcome->failure->providerCode);
        self::assertTrue($outcome->failure->retryable);
        self::assertSame(60.0, $outcome->failure->retryAfter);
        self::assertSame(1, $outcome->failure->attempts);
        self::assertSame(1, $transport->calls);
    }
}
