<?php

declare(strict_types=1);

namespace edrard\Tests\WotClient;

use edrard\Tests\WotClient\Fixtures\RecordingExecutor;
use edrard\WgApi\Realm;
use edrard\WgAuth\AccessToken;
use edrard\WgAuth\AuthClient;
use edrard\WgAuth\Contracts\AuthTransportInterface;
use edrard\WgGetter\Http\GuzzleTransport;
use edrard\WgGetter\WgDataGetter;
use edrard\WgGetter\Contracts\RateLimiterInterface;
use edrard\WotClient\ClientException;
use edrard\WotClient\Facades\Accounts;
use edrard\WotClient\Facades\Auth;
use edrard\WotClient\Facades\Wot;
use edrard\WotClient\Http\DefaultRequestExecutor;
use edrard\WotClient\InvalidResponseException;
use edrard\WotClient\Record;
use edrard\WotClient\WotClient;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use LogicException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use RuntimeException;

final class HttpAndFacadeTest extends TestCase
{
    protected function tearDown(): void
    {
        Wot::reset();
    }

    public function testFacadeIsExplicitAndMatchesInjectedClient(): void
    {
        $executor = new RecordingExecutor(static fn () => ['status' => 'ok', 'data' => [1 => ['nickname' => 'Fixture']]]);
        $client = new WotClient('fixture', executor: $executor);
        Wot::configure($client);
        self::assertSame('Fixture', Accounts::info([1])->record(1)->string('nickname'));
        self::assertSame('Fixture', Wot::accounts()->info([1])->record(1)->string('nickname'));
        Wot::forRealm(Realm::NA)->accounts()->info([1]);
        $client->accounts()->info([1]);
        self::assertSame(Realm::NA, $executor->calls[2]['realm']);
        self::assertSame(Realm::EU, $executor->calls[3]['realm']);
        Wot::reset();
        $this->expectException(LogicException::class);
        Accounts::info([1]);
    }

    public function testAuthFacadeDelegatesWithoutDuplicatingLifecycle(): void
    {
        $transport = new class () implements AuthTransportInterface {
            public array $calls = [];
            public function post(string $url, array $parameters): ?array
            {
                $this->calls[] = [$url, $parameters];
                return str_contains($url, '/login/') ? ['location' => 'https://eu.wargaming.net/id/fixture'] : null;
            }
        };
        $auth = new AuthClient('fixture', $transport);
        Wot::configure(new WotClient('fixture', authentication: $auth));
        self::assertSame($auth, Wot::auth());
        self::assertSame('https://eu.wargaming.net/id/fixture', Auth::loginLocation(Realm::EU, 'https://example.test/callback'));
        Auth::logout(new AccessToken(Realm::EU, 1, 'fixture-token', time() + 3600));
        self::assertCount(2, $transport->calls);
        self::assertStringContainsString('/auth/logout/', $transport->calls[1][0]);
    }

    public function testPublicGetUsesWgApiAndWgDataGetter(): void
    {
        $history = [];
        $stack = HandlerStack::create(new MockHandler([new Response(200, [], '{"status":"ok","data":{"1":{"account_id":1,"nickname":"Fixture"}}}') ]));
        $stack->push(Middleware::history($history));
        $getter = new WgDataGetter(transport: new GuzzleTransport(new Client(['handler' => $stack])));
        $executor = new DefaultRequestExecutor(['eu' => 'fixture-id'], getter: $getter);
        $result = (new WotClient('fixture-id', executor: $executor))->accounts()->info([1]);
        self::assertSame('Fixture', $result->record(1)->string('nickname'));
        self::assertSame('GET', $history[0]['request']->getMethod());
        self::assertSame('api.worldoftanks.eu', $history[0]['request']->getUri()->getHost());
        parse_str($history[0]['request']->getUri()->getQuery(), $query);
        self::assertSame('fixture-id', $query['application_id']);
        self::assertSame('1', $query['account_id']);
        self::assertArrayNotHasKey('access_token', $query);
        self::assertFalse($history[0]['options']['allow_redirects']);
        self::assertTrue($history[0]['options']['verify']);
    }

    public function testTokenIsOnlyInPostBodyAndWriteIsNotRetried(): void
    {
        $history = [];
        $stack = HandlerStack::create(new MockHandler([
            new Response(200, [], '{"status":"ok","data":{"1":{"nickname":"Fixture"}}}'),
            new Response(503, [], 'fixture-token'),
        ]));
        $stack->push(Middleware::history($history));
        $executor = new DefaultRequestExecutor(['eu' => 'fixture-id'], postClient: new Client(['handler' => $stack]));
        $client = new WotClient('fixture-id', executor: $executor);
        $token = new AccessToken(Realm::EU, 1, 'fixture-token', time() + 3600);
        $client->accounts()->info([1], accessToken: $token);
        self::assertSame('POST', $history[0]['request']->getMethod());
        self::assertSame('', $history[0]['request']->getUri()->getQuery());
        parse_str((string) $history[0]['request']->getBody(), $body);
        self::assertSame('fixture-token', $body['access_token']);
        self::assertSame('1', $body['account_id']);
        self::assertFalse($history[0]['options']['allow_redirects']);
        self::assertTrue($history[0]['options']['verify']);
        try {
            $client->stronghold()->activateClanReserve($token, 'fixture-reserve', 1);
            self::fail('HTTP failure ignored.');
        } catch (ClientException $exception) {
            self::assertSame(503, $exception->httpStatus);
            self::assertStringNotContainsString('fixture-token', $exception->getMessage());
            self::assertCount(2, $history);
            self::assertNull($exception->getPrevious());
        }
    }

    #[DataProvider('invalidPostBodies')]
    public function testInvalidPostEnvelopesFail(string $body): void
    {
        $stack = HandlerStack::create(new MockHandler([new Response(200, [], $body)]));
        $executor = new DefaultRequestExecutor(['eu' => 'fixture'], postClient: new Client(['handler' => $stack]));
        $token = new AccessToken(Realm::EU, 1, 'fixture-token', time() + 60);
        $this->expectException(InvalidResponseException::class);
        (new WotClient('fixture', executor: $executor))->accounts()->info([1], accessToken: $token);
    }

    public static function invalidPostBodies(): iterable
    {
        yield ['bad-json'];
        yield ['null'];
        yield ['{"status":"ok","data":"wrong"}'];
        yield [str_repeat('x', 8388609)];
    }

    public function testTransportFailureDoesNotRetainCredentialException(): void
    {
        $stack = HandlerStack::create(new MockHandler([new RuntimeException('fixture-token') ]));
        $executor = new DefaultRequestExecutor(['eu' => 'fixture'], postClient: new Client(['handler' => $stack]));
        try {
            (new WotClient('fixture', executor: $executor))->accounts()->info([1], accessToken: new AccessToken(Realm::EU, 1, 'fixture-token', time() + 60));
            self::fail('Transport failure ignored.');
        } catch (ClientException $exception) {
            self::assertStringNotContainsString('fixture-token', $exception->getMessage());
            self::assertNull($exception->getPrevious());
        }
    }

    public function testRecordTypedAccessAndDebugRedaction(): void
    {
        $record = new Record(['name' => 'private-fixture', 'flag' => false]);
        self::assertFalse($record->boolean('flag'));
        ob_start();
        var_dump($record);
        $debug = ob_get_clean();
        self::assertStringNotContainsString('private-fixture', $debug);
        $this->expectException(InvalidResponseException::class);
        $record->integer('name');
    }

    public function testDefaultExecutorSharesRateLimiterBetweenGetAndPost(): void
    {
        $limiter = new class () implements RateLimiterInterface {
            public int $count = 0;
            public function acquire(int $requests): void
            {
                $this->count += $requests;
            }
        };
        $response = '{"status":"ok","data":{"1":{"account_id":1}}}';
        $getter = new WgDataGetter(
            transport: new GuzzleTransport(new Client(['handler' => HandlerStack::create(new MockHandler([new Response(200, [], $response)]))])),
            limiter: $limiter,
        );
        $executor = new DefaultRequestExecutor(
            ['eu' => 'fixture'],
            getter: $getter,
            postClient: new Client(['handler' => HandlerStack::create(new MockHandler([new Response(200, [], $response)]))]),
            limiter: $limiter,
        );
        $client = new WotClient('fixture', executor: $executor);
        $client->accounts()->info([1]);
        $client->accounts()->info([1], accessToken: new AccessToken(Realm::EU, 1, 'fixture-token', time() + 60));
        self::assertSame(2, $limiter->count);
    }

    public function testStaticPaginationRemainsLazy(): void
    {
        $executor = new RecordingExecutor(static fn () => ['status' => 'ok', 'data' => [10 => ['tank_id' => 10]], 'meta' => ['page_total' => 1]]);
        Wot::configure(new WotClient('fixture', executor: $executor));
        $iterator = \edrard\WotClient\Facades\Encyclopedia::iterateVehicles(fields: ['tank_id']);
        self::assertSame([], $executor->calls);
        $rows = iterator_to_array($iterator);
        self::assertSame(10, $rows[10]->integer('tank_id'));
        self::assertCount(1, $executor->calls);
    }
}
