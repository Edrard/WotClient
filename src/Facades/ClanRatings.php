<?php

declare(strict_types=1);

namespace edrard\WotClient\Facades;

use edrard\WotClient\PreparedOperation;
use edrard\WgGetter\FetchResult;
use SensitiveParameter;

/** Generated from resources/endpoints.json by tools/generate-client.mjs. */
final class ClanRatings
{
    /**
     * clanratings/types. Return one raw result per URL.
     * @return list<FetchResult>
     */
    public static function types(
    ): array {
        return Wot::client()->clanRatings()->types();
    }

    /**
     * clanratings/types. Prepare without HTTP I/O.
     */
    public static function prepareTypes(
    ): PreparedOperation {
        return Wot::client()->clanRatings()->prepareTypes();
    }

    /**
     * clanratings/dates. Return one raw result per URL.
     * @return list<FetchResult>
     */
    public static function dates(
        int|null $limit = null,
    ): array {
        return Wot::client()->clanRatings()->dates($limit);
    }

    /**
     * clanratings/dates. Prepare without HTTP I/O.
     */
    public static function prepareDates(
        int|null $limit = null,
    ): PreparedOperation {
        return Wot::client()->clanRatings()->prepareDates($limit);
    }

    /**
     * clanratings/clans. Return one raw result per URL.
     * @param list<int> $clanIds
     * @param list<string> $fields
     * @return list<FetchResult>
     */
    public static function clans(
        array $clanIds,
        int $batchSize,
        string|null $language = null,
        array $fields = [],
        int|string|null $date = null,
    ): array {
        return Wot::client()->clanRatings()->clans($clanIds, $batchSize, $language, $fields, $date);
    }

    /**
     * clanratings/clans. Prepare without HTTP I/O.
     * @param list<int> $clanIds
     * @param list<string> $fields
     */
    public static function prepareClans(
        array $clanIds,
        int $batchSize,
        string|null $language = null,
        array $fields = [],
        int|string|null $date = null,
    ): PreparedOperation {
        return Wot::client()->clanRatings()->prepareClans($clanIds, $batchSize, $language, $fields, $date);
    }

    /**
     * clanratings/neighbors. Return one raw result per URL.
     * @param list<string> $fields
     * @return list<FetchResult>
     */
    public static function neighbors(
        string $rankField,
        int $clanId,
        string|null $language = null,
        array $fields = [],
        int|string|null $date = null,
        int|null $limit = null,
    ): array {
        return Wot::client()->clanRatings()->neighbors($rankField, $clanId, $language, $fields, $date, $limit);
    }

    /**
     * clanratings/neighbors. Prepare without HTTP I/O.
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
        return Wot::client()->clanRatings()->prepareNeighbors($rankField, $clanId, $language, $fields, $date, $limit);
    }

    /**
     * clanratings/top. Return one raw result per URL.
     * @param list<string> $fields
     * @return list<FetchResult>
     */
    public static function top(
        string $rankField,
        string|null $language = null,
        array $fields = [],
        int|string|null $date = null,
        int|null $pageNo = null,
        int|null $limit = null,
    ): array {
        return Wot::client()->clanRatings()->top($rankField, $language, $fields, $date, $pageNo, $limit);
    }

    /**
     * clanratings/top. Prepare without HTTP I/O.
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

}
