<?php

declare(strict_types=1);

namespace edrard\Tests\WotClient;

use edrard\Tests\WotClient\Fixtures\RecordingExecutor;
use edrard\WgApi\Realm;
use edrard\WgAuth\AccessToken;
use edrard\WotClient\Http\DefaultRequestExecutor;
use edrard\WotClient\InvalidResponseException;
use edrard\WotClient\WotClient;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

final class SecurityReviewTest extends TestCase
{
    public function testRejectedRawTokenCannotLeakThroughParameterValidationTrace(): void
    {
        $previous = ini_set('zend.exception_ignore_args', '0');
        try {
            foreach (['request', 'prepare'] as $method) {
                $executor = new RecordingExecutor();
                $client = new WotClient('fixture', executor: $executor);
                try {
                    $client->$method('account/info', ['account_id' => [42], 'access_token' => 'synthetic-trace-secret']);
                    self::fail('Reserved raw token accepted.');
                } catch (\InvalidArgumentException $exception) {
                    $frames = array_values(array_filter($exception->getTrace(), static fn (array $frame): bool => ($frame['class'] ?? null) === \edrard\WotClient\ParameterValidator::class && $frame['function'] === 'validate'));
                    self::assertCount(1, $frames);
                    self::assertInstanceOf(\SensitiveParameterValue::class, $frames[0]['args'][1]);
                    self::assertStringNotContainsString('synthetic-trace-secret', var_export($exception->getTrace(), true));
                    self::assertSame([], $executor->calls);
                }
            }
        } finally {
            ini_set('zend.exception_ignore_args', $previous);
        }
    }

    public function testWrongReportedPageCannotPassPaginationValidation(): void
    {
        $client = new WotClient('fixture', executor: new RecordingExecutor(static fn () => [
            'status' => 'ok', 'data' => [1 => ['tank_id' => 1]], 'meta' => ['page' => 99, 'page_total' => 1],
        ]));
        $this->expectException(InvalidResponseException::class);
        iterator_to_array($client->encyclopedia()->iterateVehicles());
    }

    public function testPostDefaultQueryCannotLeak(): void
    {
        $history = [];
        $stack = HandlerStack::create(new MockHandler([new Response(200, [], '{"status":"ok","data":[]}')]));
        $stack->push(Middleware::history($history));
        $http = new Client(['handler' => $stack, 'query' => ['access_token' => 'fixture-secret'], 'debug' => true]);
        $executor = new DefaultRequestExecutor(['eu' => 'fixture'], postClient: $http);
        $executor->execute(Realm::EU, 'account/info', ['account_id' => [1]], new AccessToken(Realm::EU, 1, 'fixture-secret', time() + 3600));
        self::assertSame('', $history[0]['request']->getUri()->getQuery());
        self::assertFalse($history[0]['options']['debug']);
    }

    public function testPostResponseAboveFormerSizeLimitIsReturnedInFull(): void
    {
        $envelope = ['status' => 'ok', 'data' => [1 => ['nickname' => str_repeat('x', 9 * 1024 * 1024)]]];
        $body = json_encode($envelope, JSON_THROW_ON_ERROR);
        $http = new Client(['handler' => HandlerStack::create(new MockHandler([new Response(200, [], $body)]))]);
        $executor = new DefaultRequestExecutor(['eu' => 'fixture'], postClient: $http);
        self::assertSame($envelope, $executor->execute(Realm::EU, 'account/info', ['account_id' => [1]], new AccessToken(Realm::EU, 1, 'fixture-secret', time() + 3600)));
    }

    public function testRecordCannotBeAnUnvalidatedScalarList(): void
    {
        $client = new WotClient('fixture', executor: new RecordingExecutor(static fn () => ['status' => 'ok', 'data' => [1 => [123, 'invalid']]]));
        $this->expectException(InvalidResponseException::class);
        $client->accounts()->info([1]);
    }
}
