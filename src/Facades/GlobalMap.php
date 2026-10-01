<?php

declare(strict_types=1);

namespace edrard\WotClient\Facades;

use edrard\WotClient\PreparedOperation;
use edrard\WgGetter\FetchResult;
use SensitiveParameter;

/** Generated from resources/endpoints.json by tools/generate-client.mjs. */
final class GlobalMap
{
    /**
     * globalmap/fronts. Return one raw result per URL.
     * @param list<string> $fields
     * @param list<string> $frontIds
     * @return list<FetchResult>
     */
    public static function fronts(
        array $fields = [],
        string|null $language = null,
        int|null $limit = null,
        int|null $pageNo = null,
        array $frontIds = [],
    ): array {
        return Wot::client()->globalMap()->fronts($fields, $language, $limit, $pageNo, $frontIds);
    }

    /**
     * globalmap/fronts. Prepare without HTTP I/O.
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
     * globalmap/provinces. Return one raw result per URL.
     * @param list<string> $fields
     * @param list<string> $provinceIds
     * @return list<FetchResult>
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
    ): array {
        return Wot::client()->globalMap()->provinces($frontId, $fields, $language, $limit, $pageNo, $primeHour, $landingType, $arenaId, $dailyRevenueLte, $dailyRevenueGte, $orderBy, $provinceIds);
    }

    /**
     * globalmap/provinces. Prepare without HTTP I/O.
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
        return Wot::client()->globalMap()->prepareProvinces($frontId, $fields, $language, $limit, $pageNo, $primeHour, $landingType, $arenaId, $dailyRevenueLte, $dailyRevenueGte, $orderBy, $provinceIds);
    }

    /**
     * globalmap/claninfo. Return one raw result per URL.
     * @param list<int> $clanIds
     * @param list<string> $fields
     * @return list<FetchResult>
     */
    public static function clanInfo(
        array $clanIds,
        int $batchSize,
        array $fields = [],
        #[SensitiveParameter] string|null $accessToken = null,
    ): array {
        return Wot::client()->globalMap()->clanInfo($clanIds, $batchSize, $fields, $accessToken);
    }

    /**
     * globalmap/claninfo. Prepare without HTTP I/O.
     * @param list<int> $clanIds
     * @param list<string> $fields
     */
    public static function prepareClanInfo(
        array $clanIds,
        int $batchSize,
        array $fields = [],
        #[SensitiveParameter] string|null $accessToken = null,
    ): PreparedOperation {
        return Wot::client()->globalMap()->prepareClanInfo($clanIds, $batchSize, $fields, $accessToken);
    }

    /**
     * globalmap/clanprovinces. Return one raw result per URL.
     * @param list<int> $clanIds
     * @param list<string> $fields
     * @return list<FetchResult>
     */
    public static function clanProvinces(
        array $clanIds,
        int $batchSize,
        array $fields = [],
        #[SensitiveParameter] string|null $accessToken = null,
        string|null $language = null,
    ): array {
        return Wot::client()->globalMap()->clanProvinces($clanIds, $batchSize, $fields, $accessToken, $language);
    }

    /**
     * globalmap/clanprovinces. Prepare without HTTP I/O.
     * @param list<int> $clanIds
     * @param list<string> $fields
     */
    public static function prepareClanProvinces(
        array $clanIds,
        int $batchSize,
        array $fields = [],
        #[SensitiveParameter] string|null $accessToken = null,
        string|null $language = null,
    ): PreparedOperation {
        return Wot::client()->globalMap()->prepareClanProvinces($clanIds, $batchSize, $fields, $accessToken, $language);
    }

    /**
     * globalmap/clanbattles. Return one raw result per URL.
     * @param list<string> $fields
     * @return list<FetchResult>
     */
    public static function clanBattles(
        int $clanId,
        array $fields = [],
        string|null $language = null,
        int|null $limit = null,
        int|null $pageNo = null,
    ): array {
        return Wot::client()->globalMap()->clanBattles($clanId, $fields, $language, $limit, $pageNo);
    }

    /**
     * globalmap/clanbattles. Prepare without HTTP I/O.
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
     * globalmap/seasons. Return one raw result per URL.
     * @param list<string> $fields
     * @return list<FetchResult>
     */
    public static function seasons(
        array $fields = [],
        string|null $language = null,
        int|null $pageNo = null,
        string|null $seasonId = null,
        int|null $limit = null,
        string|null $status = null,
    ): array {
        return Wot::client()->globalMap()->seasons($fields, $language, $pageNo, $seasonId, $limit, $status);
    }

    /**
     * globalmap/seasons. Prepare without HTTP I/O.
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
        return Wot::client()->globalMap()->prepareSeasons($fields, $language, $pageNo, $seasonId, $limit, $status);
    }

    /**
     * globalmap/seasonclaninfo. Return one raw result per URL.
     * @param list<string> $vehicleLevel
     * @param list<string> $fields
     * @return list<FetchResult>
     */
    public static function seasonClanInfo(
        string $seasonId,
        array $vehicleLevel,
        int $clanId,
        array $fields = [],
    ): array {
        return Wot::client()->globalMap()->seasonClanInfo($seasonId, $vehicleLevel, $clanId, $fields);
    }

    /**
     * globalmap/seasonclaninfo. Prepare without HTTP I/O.
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
     * globalmap/seasonaccountinfo. Return one raw result per URL.
     * @param list<string> $vehicleLevel
     * @param list<string> $fields
     * @return list<FetchResult>
     */
    public static function seasonAccountInfo(
        string $seasonId,
        array $vehicleLevel,
        int $accountId,
        array $fields = [],
    ): array {
        return Wot::client()->globalMap()->seasonAccountInfo($seasonId, $vehicleLevel, $accountId, $fields);
    }

    /**
     * globalmap/seasonaccountinfo. Prepare without HTTP I/O.
     * @param list<string> $vehicleLevel
     * @param list<string> $fields
     */
    public static function prepareSeasonAccountInfo(
        string $seasonId,
        array $vehicleLevel,
        int $accountId,
        array $fields = [],
    ): PreparedOperation {
        return Wot::client()->globalMap()->prepareSeasonAccountInfo($seasonId, $vehicleLevel, $accountId, $fields);
    }

    /**
     * globalmap/seasonrating. Return one raw result per URL.
     * @param list<string> $fields
     * @return list<FetchResult>
     */
    public static function seasonRating(
        string $seasonId,
        string $vehicleLevel,
        array $fields = [],
        int|null $pageNo = null,
        int|null $limit = null,
    ): array {
        return Wot::client()->globalMap()->seasonRating($seasonId, $vehicleLevel, $fields, $pageNo, $limit);
    }

    /**
     * globalmap/seasonrating. Prepare without HTTP I/O.
     * @param list<string> $fields
     */
    public static function prepareSeasonRating(
        string $seasonId,
        string $vehicleLevel,
        array $fields = [],
        int|null $pageNo = null,
        int|null $limit = null,
    ): PreparedOperation {
        return Wot::client()->globalMap()->prepareSeasonRating($seasonId, $vehicleLevel, $fields, $pageNo, $limit);
    }

    /**
     * globalmap/seasonratingneighbors. Return one raw result per URL.
     * @param list<string> $fields
     * @return list<FetchResult>
     */
    public static function seasonRatingNeighbors(
        string $seasonId,
        string $vehicleLevel,
        int $clanId,
        array $fields = [],
        int|null $limit = null,
    ): array {
        return Wot::client()->globalMap()->seasonRatingNeighbors($seasonId, $vehicleLevel, $clanId, $fields, $limit);
    }

    /**
     * globalmap/seasonratingneighbors. Prepare without HTTP I/O.
     * @param list<string> $fields
     */
    public static function prepareSeasonRatingNeighbors(
        string $seasonId,
        string $vehicleLevel,
        int $clanId,
        array $fields = [],
        int|null $limit = null,
    ): PreparedOperation {
        return Wot::client()->globalMap()->prepareSeasonRatingNeighbors($seasonId, $vehicleLevel, $clanId, $fields, $limit);
    }

    /**
     * globalmap/events. Return one raw result per URL.
     * @param list<string> $fields
     * @return list<FetchResult>
     */
    public static function events(
        array $fields = [],
        string|null $language = null,
        int|null $pageNo = null,
        string|null $eventId = null,
        int|null $limit = null,
        string|null $status = null,
    ): array {
        return Wot::client()->globalMap()->events($fields, $language, $pageNo, $eventId, $limit, $status);
    }

    /**
     * globalmap/events. Prepare without HTTP I/O.
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
        return Wot::client()->globalMap()->prepareEvents($fields, $language, $pageNo, $eventId, $limit, $status);
    }

    /**
     * globalmap/eventclaninfo. Return one raw result per URL.
     * @param list<string> $frontIds
     * @param list<string> $fields
     * @return list<FetchResult>
     */
    public static function eventClanInfo(
        string $eventId,
        array $frontIds,
        int $clanId,
        array $fields = [],
    ): array {
        return Wot::client()->globalMap()->eventClanInfo($eventId, $frontIds, $clanId, $fields);
    }

    /**
     * globalmap/eventclaninfo. Prepare without HTTP I/O.
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
     * globalmap/eventaccountinfo. Return one raw result per URL.
     * @param list<string> $frontIds
     * @param list<string> $fields
     * @return list<FetchResult>
     */
    public static function eventAccountInfo(
        string $eventId,
        array $frontIds,
        int $accountId,
        array $fields = [],
        int|null $clanId = null,
    ): array {
        return Wot::client()->globalMap()->eventAccountInfo($eventId, $frontIds, $accountId, $fields, $clanId);
    }

    /**
     * globalmap/eventaccountinfo. Prepare without HTTP I/O.
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
        return Wot::client()->globalMap()->prepareEventAccountInfo($eventId, $frontIds, $accountId, $fields, $clanId);
    }

    /**
     * globalmap/eventaccountratings. Return one raw result per URL.
     * @param list<string> $fields
     * @return list<FetchResult>
     */
    public static function eventAccountRatings(
        string $eventId,
        string $frontId,
        array $fields = [],
        int|null $pageNo = null,
        int|null $limit = null,
        int|null $inRating = null,
    ): array {
        return Wot::client()->globalMap()->eventAccountRatings($eventId, $frontId, $fields, $pageNo, $limit, $inRating);
    }

    /**
     * globalmap/eventaccountratings. Prepare without HTTP I/O.
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
        return Wot::client()->globalMap()->prepareEventAccountRatings($eventId, $frontId, $fields, $pageNo, $limit, $inRating);
    }

    /**
     * globalmap/eventaccountratingneighbors. Return one raw result per URL.
     * @param list<string> $fields
     * @return list<FetchResult>
     */
    public static function eventAccountRatingNeighbors(
        string $eventId,
        string $frontId,
        int $accountId,
        array $fields = [],
        int|null $pageNo = null,
        int|null $limit = null,
        int|null $neighboursCount = null,
    ): array {
        return Wot::client()->globalMap()->eventAccountRatingNeighbors($eventId, $frontId, $accountId, $fields, $pageNo, $limit, $neighboursCount);
    }

    /**
     * globalmap/eventaccountratingneighbors. Prepare without HTTP I/O.
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
        return Wot::client()->globalMap()->prepareEventAccountRatingNeighbors($eventId, $frontId, $accountId, $fields, $pageNo, $limit, $neighboursCount);
    }

    /**
     * globalmap/eventrating. Return one raw result per URL.
     * @param list<string> $fields
     * @return list<FetchResult>
     */
    public static function eventRating(
        string $eventId,
        string $frontId,
        array $fields = [],
        int|null $pageNo = null,
        int|null $limit = null,
    ): array {
        return Wot::client()->globalMap()->eventRating($eventId, $frontId, $fields, $pageNo, $limit);
    }

    /**
     * globalmap/eventrating. Prepare without HTTP I/O.
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
     * globalmap/eventratingneighbors. Return one raw result per URL.
     * @param list<string> $fields
     * @return list<FetchResult>
     */
    public static function eventRatingNeighbors(
        string $eventId,
        string $frontId,
        int $clanId,
        array $fields = [],
        int|null $limit = null,
    ): array {
        return Wot::client()->globalMap()->eventRatingNeighbors($eventId, $frontId, $clanId, $fields, $limit);
    }

    /**
     * globalmap/eventratingneighbors. Prepare without HTTP I/O.
     * @param list<string> $fields
     */
    public static function prepareEventRatingNeighbors(
        string $eventId,
        string $frontId,
        int $clanId,
        array $fields = [],
        int|null $limit = null,
    ): PreparedOperation {
        return Wot::client()->globalMap()->prepareEventRatingNeighbors($eventId, $frontId, $clanId, $fields, $limit);
    }

    /**
     * globalmap/info. Return one raw result per URL.
     * @param list<string> $fields
     * @return list<FetchResult>
     */
    public static function info(
        array $fields = [],
    ): array {
        return Wot::client()->globalMap()->info($fields);
    }

    /**
     * globalmap/info. Prepare without HTTP I/O.
     * @param list<string> $fields
     */
    public static function prepareInfo(
        array $fields = [],
    ): PreparedOperation {
        return Wot::client()->globalMap()->prepareInfo($fields);
    }

}
