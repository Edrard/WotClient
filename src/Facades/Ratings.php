<?php

declare(strict_types=1);

namespace edrard\WotClient\Facades;

use edrard\WotClient\PreparedOperation;
use edrard\WgGetter\FetchResult;
use SensitiveParameter;

/** Generated from resources/endpoints.json by tools/generate-client.mjs. */
final class Ratings
{
    /**
     * ratings/types. Return one raw result per URL.
     * @deprecated Marked deprecated in the WG catalog; requests remain available.
     * @param list<string> $fields
     * @return list<FetchResult>
     */
    public static function types(
        string|null $language = null,
        array $fields = [],
        string|null $battleType = null,
    ): array {
        return Wot::client()->ratings()->types($language, $fields, $battleType);
    }

    /**
     * ratings/types. Prepare without HTTP I/O.
     * @deprecated Marked deprecated in the WG catalog; requests remain available.
     * @param list<string> $fields
     */
    public static function prepareTypes(
        string|null $language = null,
        array $fields = [],
        string|null $battleType = null,
    ): PreparedOperation {
        return Wot::client()->ratings()->prepareTypes($language, $fields, $battleType);
    }

    /**
     * ratings/dates. Return one raw result per URL.
     * @deprecated Marked deprecated in the WG catalog; requests remain available.
     * @param list<string> $fields
     * @param list<int> $accountIds
     * @return list<FetchResult>
     */
    public static function dates(
        string $type,
        string|null $language = null,
        array $fields = [],
        string|null $battleType = null,
        array $accountIds = [],
    ): array {
        return Wot::client()->ratings()->dates($type, $language, $fields, $battleType, $accountIds);
    }

    /**
     * ratings/dates. Prepare without HTTP I/O.
     * @deprecated Marked deprecated in the WG catalog; requests remain available.
     * @param list<string> $fields
     * @param list<int> $accountIds
     */
    public static function prepareDates(
        string $type,
        string|null $language = null,
        array $fields = [],
        string|null $battleType = null,
        array $accountIds = [],
    ): PreparedOperation {
        return Wot::client()->ratings()->prepareDates($type, $language, $fields, $battleType, $accountIds);
    }

    /**
     * ratings/accounts. Return one raw result per URL.
     * @deprecated Marked deprecated in the WG catalog; requests remain available.
     * @param list<int> $accountIds
     * @param list<string> $fields
     * @return list<FetchResult>
     */
    public static function accounts(
        string $type,
        array $accountIds,
        int $batchSize,
        string|null $language = null,
        array $fields = [],
        string|null $battleType = null,
        int|string|null $date = null,
    ): array {
        return Wot::client()->ratings()->accounts($type, $accountIds, $batchSize, $language, $fields, $battleType, $date);
    }

    /**
     * ratings/accounts. Prepare without HTTP I/O.
     * @deprecated Marked deprecated in the WG catalog; requests remain available.
     * @param list<int> $accountIds
     * @param list<string> $fields
     */
    public static function prepareAccounts(
        string $type,
        array $accountIds,
        int $batchSize,
        string|null $language = null,
        array $fields = [],
        string|null $battleType = null,
        int|string|null $date = null,
    ): PreparedOperation {
        return Wot::client()->ratings()->prepareAccounts($type, $accountIds, $batchSize, $language, $fields, $battleType, $date);
    }

    /**
     * ratings/neighbors. Return one raw result per URL.
     * @deprecated Marked deprecated in the WG catalog; requests remain available.
     * @param list<string> $fields
     * @return list<FetchResult>
     */
    public static function neighbors(
        string $type,
        int $accountId,
        string $rankField,
        string|null $language = null,
        array $fields = [],
        string|null $battleType = null,
        int|string|null $date = null,
        int|null $limit = null,
    ): array {
        return Wot::client()->ratings()->neighbors($type, $accountId, $rankField, $language, $fields, $battleType, $date, $limit);
    }

    /**
     * ratings/neighbors. Prepare without HTTP I/O.
     * @deprecated Marked deprecated in the WG catalog; requests remain available.
     * @param list<string> $fields
     */
    public static function prepareNeighbors(
        string $type,
        int $accountId,
        string $rankField,
        string|null $language = null,
        array $fields = [],
        string|null $battleType = null,
        int|string|null $date = null,
        int|null $limit = null,
    ): PreparedOperation {
        return Wot::client()->ratings()->prepareNeighbors($type, $accountId, $rankField, $language, $fields, $battleType, $date, $limit);
    }

    /**
     * ratings/top. Return one raw result per URL.
     * @deprecated Marked deprecated in the WG catalog; requests remain available.
     * @param list<string> $fields
     * @return list<FetchResult>
     */
    public static function top(
        string $type,
        string $rankField,
        string|null $language = null,
        array $fields = [],
        string|null $battleType = null,
        int|string|null $date = null,
        int|null $limit = null,
        int|null $pageNo = null,
    ): array {
        return Wot::client()->ratings()->top($type, $rankField, $language, $fields, $battleType, $date, $limit, $pageNo);
    }

    /**
     * ratings/top. Prepare without HTTP I/O.
     * @deprecated Marked deprecated in the WG catalog; requests remain available.
     * @param list<string> $fields
     */
    public static function prepareTop(
        string $type,
        string $rankField,
        string|null $language = null,
        array $fields = [],
        string|null $battleType = null,
        int|string|null $date = null,
        int|null $limit = null,
        int|null $pageNo = null,
    ): PreparedOperation {
        return Wot::client()->ratings()->prepareTop($type, $rankField, $language, $fields, $battleType, $date, $limit, $pageNo);
    }

}
