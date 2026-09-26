<?php

declare(strict_types=1);

namespace edrard\WotClient\Facades;

use edrard\WgAuth\AccessToken;
use edrard\WotClient\ApiResult;
use edrard\WotClient\Record;
use Generator;
use SensitiveParameter;

/** Generated from resources/endpoints.json; regenerate with tools/generate-endpoints.py. */
final class Ratings
{
    /**
     * ratings/types; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     * @deprecated WG marks this endpoint deprecated; requires explicit client opt-in.
     */
    public static function types(
        string|null $language = null,
        array $fields = [],
        string|null $battleType = null,
    ): ApiResult {
        return Wot::client()->ratings()->types($language, $fields, $battleType);
    }

    /**
     * ratings/dates; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     * @param list<int> $accountIds
     * @deprecated WG marks this endpoint deprecated; requires explicit client opt-in.
     */
    public static function dates(
        string $type,
        string|null $language = null,
        array $fields = [],
        string|null $battleType = null,
        array $accountIds = [],
    ): ApiResult {
        return Wot::client()->ratings()->dates($type, $language, $fields, $battleType, $accountIds);
    }

    /**
     * ratings/accounts; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<int> $accountIds
     * @param list<string> $fields
     * @deprecated WG marks this endpoint deprecated; requires explicit client opt-in.
     */
    public static function accounts(
        string $type,
        array $accountIds,
        string|null $language = null,
        array $fields = [],
        string|null $battleType = null,
        int|string|null $date = null,
    ): ApiResult {
        return Wot::client()->ratings()->accounts($type, $accountIds, $language, $fields, $battleType, $date);
    }

    /**
     * ratings/neighbors; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     * @deprecated WG marks this endpoint deprecated; requires explicit client opt-in.
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
    ): ApiResult {
        return Wot::client()->ratings()->neighbors(
            $type,
            $accountId,
            $rankField,
            $language,
            $fields,
            $battleType,
            $date,
            $limit,
        );
    }

    /**
     * ratings/top; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     * @deprecated WG marks this endpoint deprecated; requires explicit client opt-in.
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
    ): ApiResult {
        return Wot::client()->ratings()->top(
            $type,
            $rankField,
            $language,
            $fields,
            $battleType,
            $date,
            $limit,
            $pageNo,
        );
    }

    /**
     * ratings/top; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     * @return Generator<array-key, Record|null>
     * @deprecated WG marks this endpoint deprecated; requires explicit client opt-in.
     */
    public static function iterateTop(
        string $type,
        string $rankField,
        string|null $language = null,
        array $fields = [],
        string|null $battleType = null,
        int|string|null $date = null,
        int|null $limit = null,
        int $startPage = 1,
        int $maxPages = 1000,
    ): Generator {
        return Wot::client()->ratings()->iterateTop(
            $type,
            $rankField,
            $language,
            $fields,
            $battleType,
            $date,
            $limit,
            $startPage,
            $maxPages,
        );
    }

    /**
     * ratings/top; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     * @deprecated WG marks this endpoint deprecated; requires explicit client opt-in.
     */
    public static function allTop(
        string $type,
        string $rankField,
        string|null $language = null,
        array $fields = [],
        string|null $battleType = null,
        int|string|null $date = null,
        int|null $limit = null,
        int $startPage = 1,
        int $maxPages = 1000,
    ): ApiResult {
        return Wot::client()->ratings()->allTop(
            $type,
            $rankField,
            $language,
            $fields,
            $battleType,
            $date,
            $limit,
            $startPage,
            $maxPages,
        );
    }

}
