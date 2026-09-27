<?php

declare(strict_types=1);

namespace edrard\WotClient\Facades;

use edrard\WgAuth\AccessToken;
use edrard\WotClient\ApiResult;
use edrard\WotClient\PreparedOperation;
use edrard\WotClient\Record;
use Generator;
use SensitiveParameter;

/** Generated from resources/endpoints.json; regenerate with tools/generate-endpoints.py. */
final class ClanRatings
{
    /**
     * clanratings/types; see the official reference linked in docs/ENDPOINTS.md.
     */
    public static function types(): ApiResult
    {
        return Wot::client()->clanRatings()->types();
    }

    /**
     * clanratings/types; see the official reference linked in docs/ENDPOINTS.md.
     */
    public static function prepareTypes(): PreparedOperation
    {
        return Wot::client()->clanRatings()->prepareTypes();
    }

    /**
     * clanratings/dates; see the official reference linked in docs/ENDPOINTS.md.
     */
    public static function dates(int|null $limit = null): ApiResult
    {
        return Wot::client()->clanRatings()->dates($limit);
    }

    /**
     * clanratings/dates; see the official reference linked in docs/ENDPOINTS.md.
     */
    public static function prepareDates(int|null $limit = null): PreparedOperation
    {
        return Wot::client()->clanRatings()->prepareDates($limit);
    }

    /**
     * clanratings/clans; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<int> $clanIds
     * @param list<string> $fields
     */
    public static function clans(
        array $clanIds,
        string|null $language = null,
        array $fields = [],
        int|string|null $date = null,
    ): ApiResult {
        return Wot::client()->clanRatings()->clans($clanIds, $language, $fields, $date);
    }

    /**
     * clanratings/clans; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<int> $clanIds
     * @param list<string> $fields
     */
    public static function prepareClans(
        array $clanIds,
        string|null $language = null,
        array $fields = [],
        int|string|null $date = null,
    ): PreparedOperation {
        return Wot::client()->clanRatings()->prepareClans($clanIds, $language, $fields, $date);
    }

    /**
     * clanratings/neighbors; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     */
    public static function neighbors(
        string $rankField,
        int $clanId,
        string|null $language = null,
        array $fields = [],
        int|string|null $date = null,
        int|null $limit = null,
    ): ApiResult {
        return Wot::client()->clanRatings()->neighbors($rankField, $clanId, $language, $fields, $date, $limit);
    }

    /**
     * clanratings/neighbors; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     */
    public static function prepareNeighbors(
        string $rankField,
        int $clanId,
        string|null $language = null,
        array $fields = [],
        int|string|null $date = null,
        int|null $limit = null,
    ): PreparedOperation {
        return Wot::client()->clanRatings()->prepareNeighbors(
            $rankField,
            $clanId,
            $language,
            $fields,
            $date,
            $limit,
        );
    }

    /**
     * clanratings/top; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     */
    public static function top(
        string $rankField,
        string|null $language = null,
        array $fields = [],
        int|string|null $date = null,
        int|null $pageNo = null,
        int|null $limit = null,
    ): ApiResult {
        return Wot::client()->clanRatings()->top($rankField, $language, $fields, $date, $pageNo, $limit);
    }

    /**
     * clanratings/top; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     */
    public static function prepareTop(
        string $rankField,
        string|null $language = null,
        array $fields = [],
        int|string|null $date = null,
        int|null $pageNo = null,
        int|null $limit = null,
    ): PreparedOperation {
        return Wot::client()->clanRatings()->prepareTop($rankField, $language, $fields, $date, $pageNo, $limit);
    }

    /**
     * clanratings/top; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     * @return Generator<array-key, Record|null>
     */
    public static function iterateTop(
        string $rankField,
        string|null $language = null,
        array $fields = [],
        int|string|null $date = null,
        int|null $limit = null,
        int $startPage = 1,
        int $maxPages = 1000,
    ): Generator {
        return Wot::client()->clanRatings()->iterateTop(
            $rankField,
            $language,
            $fields,
            $date,
            $limit,
            $startPage,
            $maxPages,
        );
    }

    /**
     * clanratings/top; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     */
    public static function allTop(
        string $rankField,
        string|null $language = null,
        array $fields = [],
        int|string|null $date = null,
        int|null $limit = null,
        int $startPage = 1,
        int $maxPages = 1000,
    ): ApiResult {
        return Wot::client()->clanRatings()->allTop(
            $rankField,
            $language,
            $fields,
            $date,
            $limit,
            $startPage,
            $maxPages,
        );
    }

}
