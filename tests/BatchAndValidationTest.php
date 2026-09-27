<?php

declare(strict_types=1);

namespace edrard\Tests\WotClient;

use edrard\Tests\WotClient\Fixtures\RecordingExecutor;
use edrard\WgApi\Realm;
use edrard\WgAuth\AccessToken;
use edrard\WotClient\ClientException;
use edrard\WotClient\InvalidResponseException;
use edrard\WotClient\WotClient;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class BatchAndValidationTest extends TestCase
{
    private function keyedExecutor(string $parameter = 'account_id'): RecordingExecutor
    {
        return new RecordingExecutor(static function (Realm $realm, string $path, array $parameters) use ($parameter): array {
            $data = [];
            foreach ($parameters[$parameter] as $id) {
                $data[$id] = [$parameter => $id, 'nickname' => 'Fixture'];
            }
            return ['status' => 'ok', 'data' => $data, 'meta' => ['count' => count($data)]];
        });
    }

    public function testAccountIdsAreDeduplicatedAndSplitAtDocumentedLimit(): void
    {
        $executor = $this->keyedExecutor();
        $client = new WotClient('fixture', executor: $executor);
        $result = $client->accounts()->info([...range(1, 205), 1], fields: ['account_id', 'nickname']);
        self::assertCount(205, $result);
        self::assertSame([100, 100, 5], array_map(static fn ($call) => count($call['parameters']['account_id']), $executor->calls));
        self::assertSame('Fixture', $result->record(205)->string('nickname'));
        self::assertSame(205, $result->record(205)->integer('account_id'));
        self::assertCount(3, $result->meta['batches']);
    }

    public function testAccountInfoPassesExtraFieldsAndLanguageToExecutor(): void
    {
        $executor = $this->keyedExecutor();
        $client = new WotClient('fixture', executor: $executor, language: 'en');
        $extra = ['statistics.random', 'statistics.epic'];

        $prepared = $client->accounts()->prepareInfo([1], language: 'ru', extra: $extra);
        self::assertSame('ru', $prepared->parameters()['language']);
        self::assertSame($extra, $prepared->parameters()['extra']);

        $client->accounts()->info([1], language: 'ru', extra: $extra);
        self::assertSame('ru', $executor->calls[0]['parameters']['language']);
        self::assertSame($extra, $executor->calls[0]['parameters']['extra']);
    }

    public function testStrongholdUsesTenClanLimit(): void
    {
        $executor = $this->keyedExecutor('clan_id');
        $result = (new WotClient('fixture', executor: $executor))->stronghold()->clanInfo(range(1, 23));
        self::assertCount(23, $result);
        self::assertSame([10, 10, 3], array_map(static fn ($call) => count($call['parameters']['clan_id']), $executor->calls));
    }

    #[DataProvider('invalidParameters')]
    public function testInvalidParametersFailBeforeTransport(string $path, array $parameters): void
    {
        $executor = new RecordingExecutor();
        try {
            (new WotClient('fixture', executor: $executor))->request($path, $parameters);
            self::fail('Invalid parameters accepted.');
        } catch (InvalidArgumentException) {
            self::assertSame([], $executor->calls);
        }
    }

    public static function invalidParameters(): iterable
    {
        yield 'empty IDs' => ['account/info', ['account_id' => []]];
        yield 'negative ID' => ['account/info', ['account_id' => [-1]]];
        yield 'floating ID' => ['account/info', ['account_id' => [1.5]]];
        yield 'numeric string ID' => ['account/info', ['account_id' => ['1']]];
        yield 'injected application ID' => ['account/info', ['account_id' => [1], 'application_id' => 'other']];
        yield 'raw token' => ['account/info', ['account_id' => [1], 'access_token' => 'secret']];
        yield 'invalid fields' => ['account/info', ['account_id' => [1], 'fields' => ['nickname,private']]];
        yield 'unknown option' => ['account/info', ['account_id' => [1], 'bad' => true]];
        yield 'unknown path' => ['othergame/account/info', []];
        yield 'invalid page' => ['encyclopedia/vehicles', ['page_no' => 0]];
        yield 'limit exceeded' => ['globalmap/seasons', ['limit' => 21]];
        yield 'invalid enum' => ['encyclopedia/vehicles', ['type' => ['bad']]];
        yield 'short search' => ['account/list', ['search' => 'ab']];
        yield 'garage without token' => ['tanks/stats', ['account_id' => 1, 'in_garage' => '1']];
        yield 'filter limit' => ['encyclopedia/vehicles', ['tank_id' => range(1, 101)]];
        yield 'percentile bound' => ['tanks/mastery', ['distribution' => 'xp', 'percentile' => [101]]];
        yield 'invalid calendar date' => ['clanratings/clans', ['clan_id' => [1], 'date' => '2026-02-31']];
    }

    #[DataProvider('acceptedResponses')]
    public function testSuccessfulProviderPayloadIsPassedThrough(array $envelope): void
    {
        $executor = new RecordingExecutor(static fn () => $envelope);
        $result = (new WotClient('fixture', executor: $executor))->accounts()->info([1]);
        self::assertSame($envelope, $result->envelope());
    }

    public static function acceptedResponses(): iterable
    {
        yield [['status' => 'ok']];
        yield [['status' => 'ok', 'data' => [1 => ['nickname' => 15]]]];
        yield [['status' => 'ok', 'data' => [1 => ['statistics' => ['all' => ['wins' => 'wrong']]]]]];
        yield [['status' => 'ok', 'data' => [1 => ['private' => ['is_premium' => 'wrong']]]]];
        yield [['status' => 'ok', 'data' => [1 => ['account_id' => 2]]]];
        yield [['status' => 'ok', 'data' => [2 => ['account_id' => 2]]]];
        yield [['status' => 'ok', 'data' => []]];
        yield [['status' => 'ok', 'data' => [1 => null], 'meta' => 'wrong']];
    }

    public function testMalformedErrorEnvelopeIsRejected(): void
    {
        $executor = new RecordingExecutor(static fn () => ['status' => 'error', 'error' => 'wrong']);
        $this->expectException(InvalidResponseException::class);
        (new WotClient('fixture', executor: $executor))->accounts()->info([1]);
    }

    public function testMissingAccountAndPartialFieldsRemainDistinguishable(): void
    {
        $executor = new RecordingExecutor(static fn () => ['status' => 'ok', 'data' => [1 => null, 2 => ['nickname' => 'Fixture', 'clan_id' => null, 'new_field' => 17]]]);
        $result = (new WotClient('fixture', executor: $executor))->accounts()->info([1, 2], fields: ['nickname']);
        self::assertTrue($result->has(1));
        self::assertNull($result->record(1));
        self::assertFalse($result->has(3));
        $record = $result->record(2);
        self::assertFalse($record->has('account_id'));
        self::assertTrue($record->has('clan_id'));
        self::assertNull($record->integer('clan_id'));
        self::assertSame(17, $record->get('new_field'));
    }

    public function testBatchFailureDoesNotReturnPartialResult(): void
    {
        $executor = $this->keyedExecutor();
        $calls = 0;
        $failing = new RecordingExecutor(static function (...$args) use ($executor, &$calls): array {
            if (++$calls === 2) {
                return ['status' => 'error', 'error' => ['code' => 407, 'message' => 'credential-leak']];
            }
            return $executor->execute(...$args);
        });
        try {
            (new WotClient('fixture', executor: $failing))->accounts()->info(range(1, 201));
            self::fail('Batch failure ignored.');
        } catch (ClientException $exception) {
            self::assertSame(407, $exception->providerCode);
            self::assertStringNotContainsString('credential-leak', $exception->getMessage());
            self::assertCount(2, $failing->calls);
        }
    }

    public function testTokenRequiresMatchingRealmAndFutureExpiration(): void
    {
        $executor = new RecordingExecutor();
        $client = new WotClient('fixture', executor: $executor);
        foreach ([new AccessToken(Realm::NA, 1, 'fixture-token', time() + 60), new AccessToken(Realm::EU, 1, 'fixture-token', time() - 1)] as $token) {
            try {
                $client->accounts()->info([1], accessToken: $token);
                self::fail('Invalid token accepted.');
            } catch (InvalidArgumentException) {
                self::assertSame([], $executor->calls);
            }
        }
    }

    public function testDeprecatedEndpointsRequireOptIn(): void
    {
        $executor = new RecordingExecutor();
        try {
            (new WotClient('fixture', executor: $executor))->ratings()->types();
            self::fail('Deprecated method enabled by default.');
        } catch (ClientException) {
            self::assertSame([], $executor->calls);
        }
        (new WotClient('fixture', executor: $executor, allowDeprecated: true))->ratings()->types();
        self::assertSame('ratings/types', $executor->calls[0]['path']);
    }

    public function testAccountTankListsRemainLists(): void
    {
        $executor = new RecordingExecutor(static fn () => ['status' => 'ok', 'data' => [1 => [['tank_id' => 10, 'mark_of_mastery' => 2]]]]);
        $result = (new WotClient('fixture', executor: $executor))->accounts()->tanks([1]);
        self::assertSame(10, $result->get(1)[0]['tank_id']);
    }

    public function testNestedVehicleListsArePassedThrough(): void
    {
        $executor = new RecordingExecutor(static fn () => ['status' => 'ok', 'data' => [1 => [['tank_id' => 10, 'statistics' => ['wins' => 'wrong']]]]]);
        $result = (new WotClient('fixture', executor: $executor))->accounts()->tanks([1]);
        self::assertSame('wrong', $result->get(1)[0]['statistics']['wins']);
    }

    public function testUnknownNestedFieldsAreNotMistakenForMissingKnownFields(): void
    {
        $executor = new RecordingExecutor(static fn () => ['status' => 'ok', 'data' => [1 => ['new_field' => ['nickname' => 15]]]]);
        $result = (new WotClient('fixture', executor: $executor))->accounts()->info([1], fields: ['account_id']);
        self::assertSame(['nickname' => 15], $result->record(1)->get('new_field'));
        self::assertFalse($result->record(1)->has('nickname'));
    }
}
