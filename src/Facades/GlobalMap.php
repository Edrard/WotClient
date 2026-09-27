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
final class GlobalMap
{
    /**
     * globalmap/fronts; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     * @param list<string> $frontIds
     */
    public static function fronts(
        array $fields = [],
        string|null $language = null,
        int|null $limit = null,
        int|null $pageNo = null,
        array $frontIds = [],
    ): ApiResult {
        return Wot::client()->globalMap()->fronts($fields, $language, $limit, $pageNo, $frontIds);
    }

    /**
     * globalmap/fronts; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     * @param list<string> $frontIds
     */
    public static function prepareFronts(
        array $fields = [],
        string|null $language = null,
        int|null $limit = null,
        int|null $pageNo = null,
        array $frontIds = [],
    ): PreparedOperation {
        return Wot::client()->globalMap()->prepareFronts($fields, $language, $limit, $pageNo, $frontIds);
    }

    /**
     * globalmap/fronts; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     * @param list<string> $frontIds
     * @return Generator<array-key, Record|null>
     */
    public static function iterateFronts(
        array $fields = [],
        string|null $language = null,
        int|null $limit = null,
        array $frontIds = [],
        int $startPage = 1,
        int $maxPages = 1000,
    ): Generator {
        return Wot::client()->globalMap()->iterateFronts(
            $fields,
            $language,
            $limit,
            $frontIds,
            $startPage,
            $maxPages,
        );
    }

    /**
     * globalmap/fronts; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     * @param list<string> $frontIds
     */
    public static function allFronts(
        array $fields = [],
        string|null $language = null,
        int|null $limit = null,
        array $frontIds = [],
        int $startPage = 1,
        int $maxPages = 1000,
    ): ApiResult {
        return Wot::client()->globalMap()->allFronts(
            $fields,
            $language,
            $limit,
            $frontIds,
            $startPage,
            $maxPages,
        );
    }

    /**
     * globalmap/provinces; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     * @param list<string> $provinceIds
     */
    public static function provinces(
        string $frontId,
        array $fields = [],
        string|null $language = null,
        int|null $limit = null,
        int|null $pageNo = null,
        int|null $primeHour = null,
        string|null $landingType = null,
        string|null $arenaId = null,
        int|null $dailyRevenueLte = null,
        int|null $dailyRevenueGte = null,
        string|null $orderBy = null,
        array $provinceIds = [],
    ): ApiResult {
        return Wot::client()->globalMap()->provinces(
            $frontId,
            $fields,
            $language,
            $limit,
            $pageNo,
            $primeHour,
            $landingType,
            $arenaId,
            $dailyRevenueLte,
            $dailyRevenueGte,
            $orderBy,
            $provinceIds,
        );
    }

    /**
     * globalmap/provinces; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     * @param list<string> $provinceIds
     */
    public static function prepareProvinces(
        string $frontId,
        array $fields = [],
        string|null $language = null,
        int|null $limit = null,
        int|null $pageNo = null,
        int|null $primeHour = null,
        string|null $landingType = null,
        string|null $arenaId = null,
        int|null $dailyRevenueLte = null,
        int|null $dailyRevenueGte = null,
        string|null $orderBy = null,
        array $provinceIds = [],
    ): PreparedOperation {
        return Wot::client()->globalMap()->prepareProvinces(
            $frontId,
            $fields,
            $language,
            $limit,
            $pageNo,
            $primeHour,
            $landingType,
            $arenaId,
            $dailyRevenueLte,
            $dailyRevenueGte,
            $orderBy,
            $provinceIds,
        );
    }

    /**
     * globalmap/provinces; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     * @param list<string> $provinceIds
     * @return Generator<array-key, Record|null>
     */
    public static function iterateProvinces(
        string $frontId,
        array $fields = [],
        string|null $language = null,
        int|null $limit = null,
        int|null $primeHour = null,
        string|null $landingType = null,
        string|null $arenaId = null,
        int|null $dailyRevenueLte = null,
        int|null $dailyRevenueGte = null,
        string|null $orderBy = null,
        array $provinceIds = [],
        int $startPage = 1,
        int $maxPages = 1000,
    ): Generator {
        return Wot::client()->globalMap()->iterateProvinces(
            $frontId,
            $fields,
            $language,
            $limit,
            $primeHour,
            $landingType,
            $arenaId,
            $dailyRevenueLte,
            $dailyRevenueGte,
            $orderBy,
            $provinceIds,
            $startPage,
            $maxPages,
        );
    }

    /**
     * globalmap/provinces; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     * @param list<string> $provinceIds
     */
    public static function allProvinces(
        string $frontId,
        array $fields = [],
        string|null $language = null,
        int|null $limit = null,
        int|null $primeHour = null,
        string|null $landingType = null,
        string|null $arenaId = null,
        int|null $dailyRevenueLte = null,
        int|null $dailyRevenueGte = null,
        string|null $orderBy = null,
        array $provinceIds = [],
        int $startPage = 1,
        int $maxPages = 1000,
    ): ApiResult {
        return Wot::client()->globalMap()->allProvinces(
            $frontId,
            $fields,
            $language,
            $limit,
            $primeHour,
            $landingType,
            $arenaId,
            $dailyRevenueLte,
            $dailyRevenueGte,
            $orderBy,
            $provinceIds,
            $startPage,
            $maxPages,
        );
    }

    /**
     * globalmap/claninfo; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<int> $clanIds
     * @param list<string> $fields
     */
    public static function clanInfo(
        array $clanIds,
        array $fields = [],
        #[SensitiveParameter] AccessToken|null $accessToken = null,
    ): ApiResult {
        return Wot::client()->globalMap()->clanInfo($clanIds, $fields, $accessToken);
    }

    /**
     * globalmap/claninfo; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<int> $clanIds
     * @param list<string> $fields
     */
    public static function prepareClanInfo(
        array $clanIds,
        array $fields = [],
        #[SensitiveParameter] AccessToken|null $accessToken = null,
    ): PreparedOperation {
        return Wot::client()->globalMap()->prepareClanInfo($clanIds, $fields, $accessToken);
    }

    /**
     * globalmap/clanprovinces; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<int> $clanIds
     * @param list<string> $fields
     */
    public static function clanProvinces(
        array $clanIds,
        array $fields = [],
        #[SensitiveParameter] AccessToken|null $accessToken = null,
        string|null $language = null,
    ): ApiResult {
        return Wot::client()->globalMap()->clanProvinces($clanIds, $fields, $accessToken, $language);
    }

    /**
     * globalmap/clanprovinces; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<int> $clanIds
     * @param list<string> $fields
     */
    public static function prepareClanProvinces(
        array $clanIds,
        array $fields = [],
        #[SensitiveParameter] AccessToken|null $accessToken = null,
        string|null $language = null,
    ): PreparedOperation {
        return Wot::client()->globalMap()->prepareClanProvinces($clanIds, $fields, $accessToken, $language);
    }

    /**
     * globalmap/clanbattles; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     */
    public static function clanBattles(
        int $clanId,
        array $fields = [],
        string|null $language = null,
        int|null $limit = null,
        int|null $pageNo = null,
    ): ApiResult {
        return Wot::client()->globalMap()->clanBattles($clanId, $fields, $language, $limit, $pageNo);
    }

    /**
     * globalmap/clanbattles; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     */
    public static function prepareClanBattles(
        int $clanId,
        array $fields = [],
        string|null $language = null,
        int|null $limit = null,
        int|null $pageNo = null,
    ): PreparedOperation {
        return Wot::client()->globalMap()->prepareClanBattles($clanId, $fields, $language, $limit, $pageNo);
    }

    /**
     * globalmap/clanbattles; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     * @return Generator<array-key, Record|null>
     */
    public static function iterateClanBattles(
        int $clanId,
        array $fields = [],
        string|null $language = null,
        int|null $limit = null,
        int $startPage = 1,
        int $maxPages = 1000,
    ): Generator {
        return Wot::client()->globalMap()->iterateClanBattles(
            $clanId,
            $fields,
            $language,
            $limit,
            $startPage,
            $maxPages,
        );
    }

    /**
     * globalmap/clanbattles; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     */
    public static function allClanBattles(
        int $clanId,
        array $fields = [],
        string|null $language = null,
        int|null $limit = null,
        int $startPage = 1,
        int $maxPages = 1000,
    ): ApiResult {
        return Wot::client()->globalMap()->allClanBattles(
            $clanId,
            $fields,
            $language,
            $limit,
            $startPage,
            $maxPages,
        );
    }

    /**
     * globalmap/seasons; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     */
    public static function seasons(
        array $fields = [],
        string|null $language = null,
        int|null $pageNo = null,
        string|null $seasonId = null,
        int|null $limit = null,
        string|null $status = null,
    ): ApiResult {
        return Wot::client()->globalMap()->seasons($fields, $language, $pageNo, $seasonId, $limit, $status);
    }

    /**
     * globalmap/seasons; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     */
    public static function prepareSeasons(
        array $fields = [],
        string|null $language = null,
        int|null $pageNo = null,
        string|null $seasonId = null,
        int|null $limit = null,
        string|null $status = null,
    ): PreparedOperation {
        return Wot::client()->globalMap()->prepareSeasons(
            $fields,
            $language,
            $pageNo,
            $seasonId,
            $limit,
            $status,
        );
    }

    /**
     * globalmap/seasons; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     * @return Generator<array-key, Record|null>
     */
    public static function iterateSeasons(
        array $fields = [],
        string|null $language = null,
        string|null $seasonId = null,
        int|null $limit = null,
        string|null $status = null,
        int $startPage = 1,
        int $maxPages = 1000,
    ): Generator {
        return Wot::client()->globalMap()->iterateSeasons(
            $fields,
            $language,
            $seasonId,
            $limit,
            $status,
            $startPage,
            $maxPages,
        );
    }

    /**
     * globalmap/seasons; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     */
    public static function allSeasons(
        array $fields = [],
        string|null $language = null,
        string|null $seasonId = null,
        int|null $limit = null,
        string|null $status = null,
        int $startPage = 1,
        int $maxPages = 1000,
    ): ApiResult {
        return Wot::client()->globalMap()->allSeasons(
            $fields,
            $language,
            $seasonId,
            $limit,
            $status,
            $startPage,
            $maxPages,
        );
    }

    /**
     * globalmap/seasonclaninfo; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $vehicleLevel
     * @param list<string> $fields
     */
    public static function seasonClanInfo(
        string $seasonId,
        array $vehicleLevel,
        int $clanId,
        array $fields = [],
    ): ApiResult {
        return Wot::client()->globalMap()->seasonClanInfo($seasonId, $vehicleLevel, $clanId, $fields);
    }

    /**
     * globalmap/seasonclaninfo; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $vehicleLevel
     * @param list<string> $fields
     */
    public static function prepareSeasonClanInfo(
        string $seasonId,
        array $vehicleLevel,
        int $clanId,
        array $fields = [],
    ): PreparedOperation {
        return Wot::client()->globalMap()->prepareSeasonClanInfo($seasonId, $vehicleLevel, $clanId, $fields);
    }

    /**
     * globalmap/seasonaccountinfo; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $vehicleLevel
     * @param list<string> $fields
     */
    public static function seasonAccountInfo(
        string $seasonId,
        array $vehicleLevel,
        int $accountId,
        array $fields = [],
    ): ApiResult {
        return Wot::client()->globalMap()->seasonAccountInfo($seasonId, $vehicleLevel, $accountId, $fields);
    }

    /**
     * globalmap/seasonaccountinfo; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $vehicleLevel
     * @param list<string> $fields
     */
    public static function prepareSeasonAccountInfo(
        string $seasonId,
        array $vehicleLevel,
        int $accountId,
        array $fields = [],
    ): PreparedOperation {
        return Wot::client()->globalMap()->prepareSeasonAccountInfo(
            $seasonId,
            $vehicleLevel,
            $accountId,
            $fields,
        );
    }

    /**
     * globalmap/seasonrating; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     */
    public static function seasonRating(
        string $seasonId,
        string $vehicleLevel,
        array $fields = [],
        int|null $pageNo = null,
        int|null $limit = null,
    ): ApiResult {
        return Wot::client()->globalMap()->seasonRating($seasonId, $vehicleLevel, $fields, $pageNo, $limit);
    }

    /**
     * globalmap/seasonrating; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     */
    public static function prepareSeasonRating(
        string $seasonId,
        string $vehicleLevel,
        array $fields = [],
        int|null $pageNo = null,
        int|null $limit = null,
    ): PreparedOperation {
        return Wot::client()->globalMap()->prepareSeasonRating(
            $seasonId,
            $vehicleLevel,
            $fields,
            $pageNo,
            $limit,
        );
    }

    /**
     * globalmap/seasonrating; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     * @return Generator<array-key, Record|null>
     */
    public static function iterateSeasonRating(
        string $seasonId,
        string $vehicleLevel,
        array $fields = [],
        int|null $limit = null,
        int $startPage = 1,
        int $maxPages = 1000,
    ): Generator {
        return Wot::client()->globalMap()->iterateSeasonRating(
            $seasonId,
            $vehicleLevel,
            $fields,
            $limit,
            $startPage,
            $maxPages,
        );
    }

    /**
     * globalmap/seasonrating; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     */
    public static function allSeasonRating(
        string $seasonId,
        string $vehicleLevel,
        array $fields = [],
        int|null $limit = null,
        int $startPage = 1,
        int $maxPages = 1000,
    ): ApiResult {
        return Wot::client()->globalMap()->allSeasonRating(
            $seasonId,
            $vehicleLevel,
            $fields,
            $limit,
            $startPage,
            $maxPages,
        );
    }

    /**
     * globalmap/seasonratingneighbors; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     */
    public static function seasonRatingNeighbors(
        string $seasonId,
        string $vehicleLevel,
        int $clanId,
        array $fields = [],
        int|null $limit = null,
    ): ApiResult {
        return Wot::client()->globalMap()->seasonRatingNeighbors(
            $seasonId,
            $vehicleLevel,
            $clanId,
            $fields,
            $limit,
        );
    }

    /**
     * globalmap/seasonratingneighbors; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     */
    public static function prepareSeasonRatingNeighbors(
        string $seasonId,
        string $vehicleLevel,
        int $clanId,
        array $fields = [],
        int|null $limit = null,
    ): PreparedOperation {
        return Wot::client()->globalMap()->prepareSeasonRatingNeighbors(
            $seasonId,
            $vehicleLevel,
            $clanId,
            $fields,
            $limit,
        );
    }

    /**
     * globalmap/events; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     */
    public static function events(
        array $fields = [],
        string|null $language = null,
        int|null $pageNo = null,
        string|null $eventId = null,
        int|null $limit = null,
        string|null $status = null,
    ): ApiResult {
        return Wot::client()->globalMap()->events($fields, $language, $pageNo, $eventId, $limit, $status);
    }

    /**
     * globalmap/events; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     */
    public static function prepareEvents(
        array $fields = [],
        string|null $language = null,
        int|null $pageNo = null,
        string|null $eventId = null,
        int|null $limit = null,
        string|null $status = null,
    ): PreparedOperation {
        return Wot::client()->globalMap()->prepareEvents(
            $fields,
            $language,
            $pageNo,
            $eventId,
            $limit,
            $status,
        );
    }

    /**
     * globalmap/events; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     * @return Generator<array-key, Record|null>
     */
    public static function iterateEvents(
        array $fields = [],
        string|null $language = null,
        string|null $eventId = null,
        int|null $limit = null,
        string|null $status = null,
        int $startPage = 1,
        int $maxPages = 1000,
    ): Generator {
        return Wot::client()->globalMap()->iterateEvents(
            $fields,
            $language,
            $eventId,
            $limit,
            $status,
            $startPage,
            $maxPages,
        );
    }

    /**
     * globalmap/events; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     */
    public static function allEvents(
        array $fields = [],
        string|null $language = null,
        string|null $eventId = null,
        int|null $limit = null,
        string|null $status = null,
        int $startPage = 1,
        int $maxPages = 1000,
    ): ApiResult {
        return Wot::client()->globalMap()->allEvents(
            $fields,
            $language,
            $eventId,
            $limit,
            $status,
            $startPage,
            $maxPages,
        );
    }

    /**
     * globalmap/eventclaninfo; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $frontIds
     * @param list<string> $fields
     */
    public static function eventClanInfo(string $eventId, array $frontIds, int $clanId, array $fields = []): ApiResult
    {
        return Wot::client()->globalMap()->eventClanInfo($eventId, $frontIds, $clanId, $fields);
    }

    /**
     * globalmap/eventclaninfo; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $frontIds
     * @param list<string> $fields
     */
    public static function prepareEventClanInfo(
        string $eventId,
        array $frontIds,
        int $clanId,
        array $fields = [],
    ): PreparedOperation {
        return Wot::client()->globalMap()->prepareEventClanInfo($eventId, $frontIds, $clanId, $fields);
    }

    /**
     * globalmap/eventaccountinfo; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $frontIds
     * @param list<string> $fields
     */
    public static function eventAccountInfo(
        string $eventId,
        array $frontIds,
        int $accountId,
        array $fields = [],
        int|null $clanId = null,
    ): ApiResult {
        return Wot::client()->globalMap()->eventAccountInfo($eventId, $frontIds, $accountId, $fields, $clanId);
    }

    /**
     * globalmap/eventaccountinfo; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $frontIds
     * @param list<string> $fields
     */
    public static function prepareEventAccountInfo(
        string $eventId,
        array $frontIds,
        int $accountId,
        array $fields = [],
        int|null $clanId = null,
    ): PreparedOperation {
        return Wot::client()->globalMap()->prepareEventAccountInfo(
            $eventId,
            $frontIds,
            $accountId,
            $fields,
            $clanId,
        );
    }

    /**
     * globalmap/eventaccountratings; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     */
    public static function eventAccountRatings(
        string $eventId,
        string $frontId,
        array $fields = [],
        int|null $pageNo = null,
        int|null $limit = null,
        int|null $inRating = null,
    ): ApiResult {
        return Wot::client()->globalMap()->eventAccountRatings(
            $eventId,
            $frontId,
            $fields,
            $pageNo,
            $limit,
            $inRating,
        );
    }

    /**
     * globalmap/eventaccountratings; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     */
    public static function prepareEventAccountRatings(
        string $eventId,
        string $frontId,
        array $fields = [],
        int|null $pageNo = null,
        int|null $limit = null,
        int|null $inRating = null,
    ): PreparedOperation {
        return Wot::client()->globalMap()->prepareEventAccountRatings(
            $eventId,
            $frontId,
            $fields,
            $pageNo,
            $limit,
            $inRating,
        );
    }

    /**
     * globalmap/eventaccountratings; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     * @return Generator<array-key, Record|null>
     */
    public static function iterateEventAccountRatings(
        string $eventId,
        string $frontId,
        array $fields = [],
        int|null $limit = null,
        int|null $inRating = null,
        int $startPage = 1,
        int $maxPages = 1000,
    ): Generator {
        return Wot::client()->globalMap()->iterateEventAccountRatings(
            $eventId,
            $frontId,
            $fields,
            $limit,
            $inRating,
            $startPage,
            $maxPages,
        );
    }

    /**
     * globalmap/eventaccountratings; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     */
    public static function allEventAccountRatings(
        string $eventId,
        string $frontId,
        array $fields = [],
        int|null $limit = null,
        int|null $inRating = null,
        int $startPage = 1,
        int $maxPages = 1000,
    ): ApiResult {
        return Wot::client()->globalMap()->allEventAccountRatings(
            $eventId,
            $frontId,
            $fields,
            $limit,
            $inRating,
            $startPage,
            $maxPages,
        );
    }

    /**
     * globalmap/eventaccountratingneighbors; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     */
    public static function eventAccountRatingNeighbors(
        string $eventId,
        string $frontId,
        int $accountId,
        array $fields = [],
        int|null $pageNo = null,
        int|null $limit = null,
        int|null $neighboursCount = null,
    ): ApiResult {
        return Wot::client()->globalMap()->eventAccountRatingNeighbors(
            $eventId,
            $frontId,
            $accountId,
            $fields,
            $pageNo,
            $limit,
            $neighboursCount,
        );
    }

    /**
     * globalmap/eventaccountratingneighbors; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     */
    public static function prepareEventAccountRatingNeighbors(
        string $eventId,
        string $frontId,
        int $accountId,
        array $fields = [],
        int|null $pageNo = null,
        int|null $limit = null,
        int|null $neighboursCount = null,
    ): PreparedOperation {
        return Wot::client()->globalMap()->prepareEventAccountRatingNeighbors(
            $eventId,
            $frontId,
            $accountId,
            $fields,
            $pageNo,
            $limit,
            $neighboursCount,
        );
    }

    /**
     * globalmap/eventaccountratingneighbors; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     * @return Generator<array-key, Record|null>
     */
    public static function iterateEventAccountRatingNeighbors(
        string $eventId,
        string $frontId,
        int $accountId,
        array $fields = [],
        int|null $limit = null,
        int|null $neighboursCount = null,
        int $startPage = 1,
        int $maxPages = 1000,
    ): Generator {
        return Wot::client()->globalMap()->iterateEventAccountRatingNeighbors(
            $eventId,
            $frontId,
            $accountId,
            $fields,
            $limit,
            $neighboursCount,
            $startPage,
            $maxPages,
        );
    }

    /**
     * globalmap/eventaccountratingneighbors; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     */
    public static function allEventAccountRatingNeighbors(
        string $eventId,
        string $frontId,
        int $accountId,
        array $fields = [],
        int|null $limit = null,
        int|null $neighboursCount = null,
        int $startPage = 1,
        int $maxPages = 1000,
    ): ApiResult {
        return Wot::client()->globalMap()->allEventAccountRatingNeighbors(
            $eventId,
            $frontId,
            $accountId,
            $fields,
            $limit,
            $neighboursCount,
            $startPage,
            $maxPages,
        );
    }

    /**
     * globalmap/eventrating; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     */
    public static function eventRating(
        string $eventId,
        string $frontId,
        array $fields = [],
        int|null $pageNo = null,
        int|null $limit = null,
    ): ApiResult {
        return Wot::client()->globalMap()->eventRating($eventId, $frontId, $fields, $pageNo, $limit);
    }

    /**
     * globalmap/eventrating; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     */
    public static function prepareEventRating(
        string $eventId,
        string $frontId,
        array $fields = [],
        int|null $pageNo = null,
        int|null $limit = null,
    ): PreparedOperation {
        return Wot::client()->globalMap()->prepareEventRating($eventId, $frontId, $fields, $pageNo, $limit);
    }

    /**
     * globalmap/eventrating; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     * @return Generator<array-key, Record|null>
     */
    public static function iterateEventRating(
        string $eventId,
        string $frontId,
        array $fields = [],
        int|null $limit = null,
        int $startPage = 1,
        int $maxPages = 1000,
    ): Generator {
        return Wot::client()->globalMap()->iterateEventRating(
            $eventId,
            $frontId,
            $fields,
            $limit,
            $startPage,
            $maxPages,
        );
    }

    /**
     * globalmap/eventrating; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     */
    public static function allEventRating(
        string $eventId,
        string $frontId,
        array $fields = [],
        int|null $limit = null,
        int $startPage = 1,
        int $maxPages = 1000,
    ): ApiResult {
        return Wot::client()->globalMap()->allEventRating(
            $eventId,
            $frontId,
            $fields,
            $limit,
            $startPage,
            $maxPages,
        );
    }

    /**
     * globalmap/eventratingneighbors; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     */
    public static function eventRatingNeighbors(
        string $eventId,
        string $frontId,
        int $clanId,
        array $fields = [],
        int|null $limit = null,
    ): ApiResult {
        return Wot::client()->globalMap()->eventRatingNeighbors($eventId, $frontId, $clanId, $fields, $limit);
    }

    /**
     * globalmap/eventratingneighbors; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     */
    public static function prepareEventRatingNeighbors(
        string $eventId,
        string $frontId,
        int $clanId,
        array $fields = [],
        int|null $limit = null,
    ): PreparedOperation {
        return Wot::client()->globalMap()->prepareEventRatingNeighbors(
            $eventId,
            $frontId,
            $clanId,
            $fields,
            $limit,
        );
    }

    /**
     * globalmap/info; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     */
    public static function info(array $fields = []): ApiResult
    {
        return Wot::client()->globalMap()->info($fields);
    }

    /**
     * globalmap/info; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     */
    public static function prepareInfo(array $fields = []): PreparedOperation
    {
        return Wot::client()->globalMap()->prepareInfo($fields);
    }

}
