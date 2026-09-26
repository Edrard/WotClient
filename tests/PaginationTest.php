<?php

declare(strict_types=1);

namespace edrard\Tests\WotClient;

use edrard\Tests\WotClient\Fixtures\RecordingExecutor;
use edrard\WgApi\Realm;
use edrard\WotClient\ClientException;
use edrard\WotClient\InvalidResponseException;
use edrard\WotClient\WotClient;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class PaginationTest extends TestCase
{
    public function testIterationIsLazyAndUsesDeclaredLastPage(): void
    {
        $executor = new RecordingExecutor(static function (Realm $realm, string $path, array $parameters): array {
            $page = $parameters['page_no'];
            return ['status' => 'ok', 'data' => [$page => ['tank_id' => $page, 'name' => 'Fixture']], 'meta' => ['page_no' => $page, 'page_total' => 3]];
        });
        $client = new WotClient('fixture', executor: $executor);
        $iterator = $client->encyclopedia()->iterateVehicles(fields: ['tank_id', 'name'], limit: 1);
        self::assertSame([], $executor->calls);
        $iterator->rewind();
        self::assertSame(1, $iterator->current()->integer('tank_id'));
        self::assertCount(1, $executor->calls);
        $rows = iterator_to_array($iterator);
        self::assertSame([1, 2, 3], array_keys($rows));
        self::assertCount(3, $executor->calls);
        self::assertSame(['tank_id', 'name'], $executor->calls[2]['parameters']['fields']);
    }

    public function testShortPageDoesNotEndIterationWithoutMetadata(): void
    {
        $executor = new RecordingExecutor(static fn (Realm $realm, string $path, array $parameters): array => [
            'status' => 'ok', 'data' => $parameters['page_no'] <= 2 ? [['clan_id' => $parameters['page_no'], 'name' => 'Fixture']] : [],
        ]);
        $client = new WotClient('fixture', executor: $executor);
        $rows = iterator_to_array($client->clans()->iterateSearch(limit: 100));
        self::assertSame([0, 1], array_keys($rows));
        self::assertCount(3, $executor->calls);
        self::assertSame(2, $rows[1]->integer('clan_id'));
    }

    public function testAllAppendsListsAndPreservesMapKeys(): void
    {
        $executor = new RecordingExecutor(static fn (Realm $realm, string $path, array $parameters): array => [
            'status' => 'ok', 'data' => [['clan_id' => $parameters['page_no']]], 'meta' => ['page_total' => 2],
        ]);
        $result = (new WotClient('fixture', executor: $executor))->clans()->allSearch();
        self::assertCount(2, $result);
        self::assertSame(2, $result->record(1)->integer('clan_id'));
        self::assertSame(2, $result->meta['pages']);
    }

    public function testIterationCanBeginAtRequestedPage(): void
    {
        $executor = new RecordingExecutor(static fn (Realm $realm, string $path, array $parameters): array => [
            'status' => 'ok', 'data' => [5 => ['tank_id' => 5]], 'meta' => ['page_total' => 5, 'page_no' => $parameters['page_no']],
        ]);
        $result = (new WotClient('fixture', executor: $executor))->encyclopedia()->allVehicles(startPage: 5);
        self::assertSame([5], array_keys($result->data()));
        self::assertSame(5, $executor->calls[0]['parameters']['page_no']);
    }

    #[DataProvider('invalidPagination')]
    public function testInvalidPaginationMetadataFails(array $meta, array $data): void
    {
        $executor = new RecordingExecutor(static fn () => ['status' => 'ok', 'data' => $data, 'meta' => $meta]);
        $this->expectException(InvalidResponseException::class);
        (new WotClient('fixture', executor: $executor))->encyclopedia()->allVehicles();
    }

    public static function invalidPagination(): iterable
    {
        yield 'string total' => [['page_total' => '2'], [10 => ['tank_id' => 10]]];
        yield 'negative total' => [['page_total' => -1], []];
        yield 'wrong page' => [['page_no' => 2, 'page_total' => 2], [10 => ['tank_id' => 10]]];
        yield 'premature empty page' => [['page_total' => 3], []];
        yield 'records beyond last page' => [['page_total' => 0], [10 => ['tank_id' => 10]]];
    }

    public function testRepeatedPageIsRejected(): void
    {
        $executor = new RecordingExecutor(static fn () => ['status' => 'ok', 'data' => [10 => ['tank_id' => 10]]]);
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage('repeated');
        (new WotClient('fixture', executor: $executor))->encyclopedia()->allVehicles();
    }

    public function testSafetyLimitDoesNotSilentlyTruncate(): void
    {
        $executor = new RecordingExecutor(static fn (Realm $realm, string $path, array $parameters): array => [
            'status' => 'ok', 'data' => [$parameters['page_no'] => ['tank_id' => $parameters['page_no']]],
        ]);
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage('incomplete');
        (new WotClient('fixture', executor: $executor))->encyclopedia()->allVehicles(maxPages: 2);
    }

    public function testDuplicateMapKeysAcrossDifferentPagesAreRejectedByAll(): void
    {
        $executor = new RecordingExecutor(static fn (Realm $realm, string $path, array $parameters): array => [
            'status' => 'ok', 'data' => [10 => ['tank_id' => 10, 'name' => 'Page '.$parameters['page_no']]], 'meta' => ['page_total' => 2],
        ]);
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage('duplicate');
        (new WotClient('fixture', executor: $executor))->encyclopedia()->allVehicles();
    }

    public function testNonPagedMethodIsRejectedBeforeRequests(): void
    {
        $executor = new RecordingExecutor();
        try {
            iterator_to_array((new WotClient('fixture', executor: $executor))->pages('account/list', ['search' => 'Player']));
            self::fail('Unsupported pagination accepted.');
        } catch (InvalidArgumentException) {
            self::assertSame([], $executor->calls);
        }
    }
}
