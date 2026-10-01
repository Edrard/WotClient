<?php

declare(strict_types=1);

namespace edrard\WotClient\Services;

use edrard\WotClient\PreparedOperation;
use edrard\WgGetter\FetchResult;
use SensitiveParameter;

/** Generated from resources/endpoints.json by tools/generate-client.mjs. */
final readonly class GlobalMap extends Service
{
    /**
     * globalmap/fronts. Return one raw result per URL.
     * @param list<string> $fields
     * @param list<string> $frontIds
     * @return list<FetchResult>
     */
    public function fronts(
        array $fields = [],
        string|null $language = null,
        int|null $limit = null,
        int|null $pageNo = null,
        array $frontIds = [],
    ): array {
        return $this->client->request(
            'globalmap/fronts',
            [
                'fields' => $fields,
                'language' => $language,
                'limit' => $limit,
                'page_no' => $pageNo,
                'front_id' => $frontIds,
            ],
            null,
        );
    }

    /**
     * globalmap/fronts. Prepare without HTTP I/O.
     * @param list<string> $fields
     * @param list<string> $frontIds
     */
    public function prepareFronts(
        array $fields = [],
        string|null $language = null,
        int|null $limit = null,
        int|null $pageNo = null,
        array $frontIds = [],
    ): PreparedOperation {
        return $this->client->prepare(
            'globalmap/fronts',
            [
                'fields' => $fields,
                'language' => $language,
                'limit' => $limit,
                'page_no' => $pageNo,
                'front_id' => $frontIds,
            ],
            null,
        );
    }

    /**
     * globalmap/provinces. Return one raw result per URL.
     * @param list<string> $fields
     * @param list<string> $provinceIds
     * @return list<FetchResult>
     */
    public function provinces(
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
        return $this->client->request(
            'globalmap/provinces',
            [
                'front_id' => $frontId,
                'fields' => $fields,
                'language' => $language,
                'limit' => $limit,
                'page_no' => $pageNo,
                'prime_hour' => $primeHour,
                'landing_type' => $landingType,
                'arena_id' => $arenaId,
                'daily_revenue_lte' => $dailyRevenueLte,
                'daily_revenue_gte' => $dailyRevenueGte,
                'order_by' => $orderBy,
                'province_id' => $provinceIds,
            ],
            null,
        );
    }

    /**
     * globalmap/provinces. Prepare without HTTP I/O.
     * @param list<string> $fields
     * @param list<string> $provinceIds
     */
    public function prepareProvinces(
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
        return $this->client->prepare(
            'globalmap/provinces',
            [
                'front_id' => $frontId,
                'fields' => $fields,
                'language' => $language,
                'limit' => $limit,
                'page_no' => $pageNo,
                'prime_hour' => $primeHour,
                'landing_type' => $landingType,
                'arena_id' => $arenaId,
                'daily_revenue_lte' => $dailyRevenueLte,
                'daily_revenue_gte' => $dailyRevenueGte,
                'order_by' => $orderBy,
                'province_id' => $provinceIds,
            ],
            null,
        );
    }

    /**
     * globalmap/claninfo. Return one raw result per URL.
     * @param list<int> $clanIds
     * @param list<string> $fields
     * @return list<FetchResult>
     */
    public function clanInfo(
        array $clanIds,
        int $batchSize,
        array $fields = [],
        #[SensitiveParameter] string|null $accessToken = null,
    ): array {
        return $this->client->request(
            'globalmap/claninfo',
            [
                'clan_id' => $clanIds,
                'fields' => $fields,
                'access_token' => $accessToken,
            ],
            $batchSize,
        );
    }

    /**
     * globalmap/claninfo. Prepare without HTTP I/O.
     * @param list<int> $clanIds
     * @param list<string> $fields
     */
    public function prepareClanInfo(
        array $clanIds,
        int $batchSize,
        array $fields = [],
        #[SensitiveParameter] string|null $accessToken = null,
    ): PreparedOperation {
        return $this->client->prepare(
            'globalmap/claninfo',
            [
                'clan_id' => $clanIds,
                'fields' => $fields,
                'access_token' => $accessToken,
            ],
            $batchSize,
        );
    }

    /**
     * globalmap/clanprovinces. Return one raw result per URL.
     * @param list<int> $clanIds
     * @param list<string> $fields
     * @return list<FetchResult>
     */
    public function clanProvinces(
        array $clanIds,
        int $batchSize,
        array $fields = [],
        #[SensitiveParameter] string|null $accessToken = null,
        string|null $language = null,
    ): array {
        return $this->client->request(
            'globalmap/clanprovinces',
            [
                'clan_id' => $clanIds,
                'fields' => $fields,
                'access_token' => $accessToken,
                'language' => $language,
            ],
            $batchSize,
        );
    }

    /**
     * globalmap/clanprovinces. Prepare without HTTP I/O.
     * @param list<int> $clanIds
     * @param list<string> $fields
     */
    public function prepareClanProvinces(
        array $clanIds,
        int $batchSize,
        array $fields = [],
        #[SensitiveParameter] string|null $accessToken = null,
        string|null $language = null,
    ): PreparedOperation {
        return $this->client->prepare(
            'globalmap/clanprovinces',
            [
                'clan_id' => $clanIds,
                'fields' => $fields,
                'access_token' => $accessToken,
                'language' => $language,
            ],
            $batchSize,
        );
    }

    /**
     * globalmap/clanbattles. Return one raw result per URL.
     * @param list<string> $fields
     * @return list<FetchResult>
     */
    public function clanBattles(
        int $clanId,
        array $fields = [],
        string|null $language = null,
        int|null $limit = null,
        int|null $pageNo = null,
    ): array {
        return $this->client->request(
            'globalmap/clanbattles',
            [
                'clan_id' => $clanId,
                'fields' => $fields,
                'language' => $language,
                'limit' => $limit,
                'page_no' => $pageNo,
            ],
            null,
        );
    }

    /**
     * globalmap/clanbattles. Prepare without HTTP I/O.
     * @param list<string> $fields
     */
    public function prepareClanBattles(
        int $clanId,
        array $fields = [],
        string|null $language = null,
        int|null $limit = null,
        int|null $pageNo = null,
    ): PreparedOperation {
        return $this->client->prepare(
            'globalmap/clanbattles',
            [
                'clan_id' => $clanId,
                'fields' => $fields,
                'language' => $language,
                'limit' => $limit,
                'page_no' => $pageNo,
            ],
            null,
        );
    }

    /**
     * globalmap/seasons. Return one raw result per URL.
     * @param list<string> $fields
     * @return list<FetchResult>
     */
    public function seasons(
        array $fields = [],
        string|null $language = null,
        int|null $pageNo = null,
        string|null $seasonId = null,
        int|null $limit = null,
        string|null $status = null,
    ): array {
        return $this->client->request(
            'globalmap/seasons',
            [
                'fields' => $fields,
                'language' => $language,
                'page_no' => $pageNo,
                'season_id' => $seasonId,
                'limit' => $limit,
                'status' => $status,
            ],
            null,
        );
    }

    /**
     * globalmap/seasons. Prepare without HTTP I/O.
     * @param list<string> $fields
     */
    public function prepareSeasons(
        array $fields = [],
        string|null $language = null,
        int|null $pageNo = null,
        string|null $seasonId = null,
        int|null $limit = null,
        string|null $status = null,
    ): PreparedOperation {
        return $this->client->prepare(
            'globalmap/seasons',
            [
                'fields' => $fields,
                'language' => $language,
                'page_no' => $pageNo,
                'season_id' => $seasonId,
                'limit' => $limit,
                'status' => $status,
            ],
            null,
        );
    }

    /**
     * globalmap/seasonclaninfo. Return one raw result per URL.
     * @param list<string> $vehicleLevel
     * @param list<string> $fields
     * @return list<FetchResult>
     */
    public function seasonClanInfo(
        string $seasonId,
        array $vehicleLevel,
        int $clanId,
        array $fields = [],
    ): array {
        return $this->client->request(
            'globalmap/seasonclaninfo',
            [
                'season_id' => $seasonId,
                'vehicle_level' => $vehicleLevel,
                'clan_id' => $clanId,
                'fields' => $fields,
            ],
            null,
        );
    }

    /**
     * globalmap/seasonclaninfo. Prepare without HTTP I/O.
     * @param list<string> $vehicleLevel
     * @param list<string> $fields
     */
    public function prepareSeasonClanInfo(
        string $seasonId,
        array $vehicleLevel,
        int $clanId,
        array $fields = [],
    ): PreparedOperation {
        return $this->client->prepare(
            'globalmap/seasonclaninfo',
            [
                'season_id' => $seasonId,
                'vehicle_level' => $vehicleLevel,
                'clan_id' => $clanId,
                'fields' => $fields,
            ],
            null,
        );
    }

    /**
     * globalmap/seasonaccountinfo. Return one raw result per URL.
     * @param list<string> $vehicleLevel
     * @param list<string> $fields
     * @return list<FetchResult>
     */
    public function seasonAccountInfo(
        string $seasonId,
        array $vehicleLevel,
        int $accountId,
        array $fields = [],
    ): array {
        return $this->client->request(
            'globalmap/seasonaccountinfo',
            [
                'season_id' => $seasonId,
                'vehicle_level' => $vehicleLevel,
                'account_id' => $accountId,
                'fields' => $fields,
            ],
            null,
        );
    }

    /**
     * globalmap/seasonaccountinfo. Prepare without HTTP I/O.
     * @param list<string> $vehicleLevel
     * @param list<string> $fields
     */
    public function prepareSeasonAccountInfo(
        string $seasonId,
        array $vehicleLevel,
        int $accountId,
        array $fields = [],
    ): PreparedOperation {
        return $this->client->prepare(
            'globalmap/seasonaccountinfo',
            [
                'season_id' => $seasonId,
                'vehicle_level' => $vehicleLevel,
                'account_id' => $accountId,
                'fields' => $fields,
            ],
            null,
        );
    }

    /**
     * globalmap/seasonrating. Return one raw result per URL.
     * @param list<string> $fields
     * @return list<FetchResult>
     */
    public function seasonRating(
        string $seasonId,
        string $vehicleLevel,
        array $fields = [],
        int|null $pageNo = null,
        int|null $limit = null,
    ): array {
        return $this->client->request(
            'globalmap/seasonrating',
            [
                'season_id' => $seasonId,
                'vehicle_level' => $vehicleLevel,
                'fields' => $fields,
                'page_no' => $pageNo,
                'limit' => $limit,
            ],
            null,
        );
    }

    /**
     * globalmap/seasonrating. Prepare without HTTP I/O.
     * @param list<string> $fields
     */
    public function prepareSeasonRating(
        string $seasonId,
        string $vehicleLevel,
        array $fields = [],
        int|null $pageNo = null,
        int|null $limit = null,
    ): PreparedOperation {
        return $this->client->prepare(
            'globalmap/seasonrating',
            [
                'season_id' => $seasonId,
                'vehicle_level' => $vehicleLevel,
                'fields' => $fields,
                'page_no' => $pageNo,
                'limit' => $limit,
            ],
            null,
        );
    }

    /**
     * globalmap/seasonratingneighbors. Return one raw result per URL.
     * @param list<string> $fields
     * @return list<FetchResult>
     */
    public function seasonRatingNeighbors(
        string $seasonId,
        string $vehicleLevel,
        int $clanId,
        array $fields = [],
        int|null $limit = null,
    ): array {
        return $this->client->request(
            'globalmap/seasonratingneighbors',
            [
                'season_id' => $seasonId,
                'vehicle_level' => $vehicleLevel,
                'clan_id' => $clanId,
                'fields' => $fields,
                'limit' => $limit,
            ],
            null,
        );
    }

    /**
     * globalmap/seasonratingneighbors. Prepare without HTTP I/O.
     * @param list<string> $fields
     */
    public function prepareSeasonRatingNeighbors(
        string $seasonId,
        string $vehicleLevel,
        int $clanId,
        array $fields = [],
        int|null $limit = null,
    ): PreparedOperation {
        return $this->client->prepare(
            'globalmap/seasonratingneighbors',
            [
                'season_id' => $seasonId,
                'vehicle_level' => $vehicleLevel,
                'clan_id' => $clanId,
                'fields' => $fields,
                'limit' => $limit,
            ],
            null,
        );
    }

    /**
     * globalmap/events. Return one raw result per URL.
     * @param list<string> $fields
     * @return list<FetchResult>
     */
    public function events(
        array $fields = [],
        string|null $language = null,
        int|null $pageNo = null,
        string|null $eventId = null,
        int|null $limit = null,
        string|null $status = null,
    ): array {
        return $this->client->request(
            'globalmap/events',
            [
                'fields' => $fields,
                'language' => $language,
                'page_no' => $pageNo,
                'event_id' => $eventId,
                'limit' => $limit,
                'status' => $status,
            ],
            null,
        );
    }

    /**
     * globalmap/events. Prepare without HTTP I/O.
     * @param list<string> $fields
     */
    public function prepareEvents(
        array $fields = [],
        string|null $language = null,
        int|null $pageNo = null,
        string|null $eventId = null,
        int|null $limit = null,
        string|null $status = null,
    ): PreparedOperation {
        return $this->client->prepare(
            'globalmap/events',
            [
                'fields' => $fields,
                'language' => $language,
                'page_no' => $pageNo,
                'event_id' => $eventId,
                'limit' => $limit,
                'status' => $status,
            ],
            null,
        );
    }

    /**
     * globalmap/eventclaninfo. Return one raw result per URL.
     * @param list<string> $frontIds
     * @param list<string> $fields
     * @return list<FetchResult>
     */
    public function eventClanInfo(
        string $eventId,
        array $frontIds,
        int $clanId,
        array $fields = [],
    ): array {
        return $this->client->request(
            'globalmap/eventclaninfo',
            [
                'event_id' => $eventId,
                'front_id' => $frontIds,
                'clan_id' => $clanId,
                'fields' => $fields,
            ],
            null,
        );
    }

    /**
     * globalmap/eventclaninfo. Prepare without HTTP I/O.
     * @param list<string> $frontIds
     * @param list<string> $fields
     */
    public function prepareEventClanInfo(
        string $eventId,
        array $frontIds,
        int $clanId,
        array $fields = [],
    ): PreparedOperation {
        return $this->client->prepare(
            'globalmap/eventclaninfo',
            [
                'event_id' => $eventId,
                'front_id' => $frontIds,
                'clan_id' => $clanId,
                'fields' => $fields,
            ],
            null,
        );
    }

    /**
     * globalmap/eventaccountinfo. Return one raw result per URL.
     * @param list<string> $frontIds
     * @param list<string> $fields
     * @return list<FetchResult>
     */
    public function eventAccountInfo(
        string $eventId,
        array $frontIds,
        int $accountId,
        array $fields = [],
        int|null $clanId = null,
    ): array {
        return $this->client->request(
            'globalmap/eventaccountinfo',
            [
                'event_id' => $eventId,
                'front_id' => $frontIds,
                'account_id' => $accountId,
                'fields' => $fields,
                'clan_id' => $clanId,
            ],
            null,
        );
    }

    /**
     * globalmap/eventaccountinfo. Prepare without HTTP I/O.
     * @param list<string> $frontIds
     * @param list<string> $fields
     */
    public function prepareEventAccountInfo(
        string $eventId,
        array $frontIds,
        int $accountId,
        array $fields = [],
        int|null $clanId = null,
    ): PreparedOperation {
        return $this->client->prepare(
            'globalmap/eventaccountinfo',
            [
                'event_id' => $eventId,
                'front_id' => $frontIds,
                'account_id' => $accountId,
                'fields' => $fields,
                'clan_id' => $clanId,
            ],
            null,
        );
    }

    /**
     * globalmap/eventaccountratings. Return one raw result per URL.
     * @param list<string> $fields
     * @return list<FetchResult>
     */
    public function eventAccountRatings(
        string $eventId,
        string $frontId,
        array $fields = [],
        int|null $pageNo = null,
        int|null $limit = null,
        int|null $inRating = null,
    ): array {
        return $this->client->request(
            'globalmap/eventaccountratings',
            [
                'event_id' => $eventId,
                'front_id' => $frontId,
                'fields' => $fields,
                'page_no' => $pageNo,
                'limit' => $limit,
                'in_rating' => $inRating,
            ],
            null,
        );
    }

    /**
     * globalmap/eventaccountratings. Prepare without HTTP I/O.
     * @param list<string> $fields
     */
    public function prepareEventAccountRatings(
        string $eventId,
        string $frontId,
        array $fields = [],
        int|null $pageNo = null,
        int|null $limit = null,
        int|null $inRating = null,
    ): PreparedOperation {
        return $this->client->prepare(
            'globalmap/eventaccountratings',
            [
                'event_id' => $eventId,
                'front_id' => $frontId,
                'fields' => $fields,
                'page_no' => $pageNo,
                'limit' => $limit,
                'in_rating' => $inRating,
            ],
            null,
        );
    }

    /**
     * globalmap/eventaccountratingneighbors. Return one raw result per URL.
     * @param list<string> $fields
     * @return list<FetchResult>
     */
    public function eventAccountRatingNeighbors(
        string $eventId,
        string $frontId,
        int $accountId,
        array $fields = [],
        int|null $pageNo = null,
        int|null $limit = null,
        int|null $neighboursCount = null,
    ): array {
        return $this->client->request(
            'globalmap/eventaccountratingneighbors',
            [
                'event_id' => $eventId,
                'front_id' => $frontId,
                'account_id' => $accountId,
                'fields' => $fields,
                'page_no' => $pageNo,
                'limit' => $limit,
                'neighbours_count' => $neighboursCount,
            ],
            null,
        );
    }

    /**
     * globalmap/eventaccountratingneighbors. Prepare without HTTP I/O.
     * @param list<string> $fields
     */
    public function prepareEventAccountRatingNeighbors(
        string $eventId,
        string $frontId,
        int $accountId,
        array $fields = [],
        int|null $pageNo = null,
        int|null $limit = null,
        int|null $neighboursCount = null,
    ): PreparedOperation {
        return $this->client->prepare(
            'globalmap/eventaccountratingneighbors',
            [
                'event_id' => $eventId,
                'front_id' => $frontId,
                'account_id' => $accountId,
                'fields' => $fields,
                'page_no' => $pageNo,
                'limit' => $limit,
                'neighbours_count' => $neighboursCount,
            ],
            null,
        );
    }

    /**
     * globalmap/eventrating. Return one raw result per URL.
     * @param list<string> $fields
     * @return list<FetchResult>
     */
    public function eventRating(
        string $eventId,
        string $frontId,
        array $fields = [],
        int|null $pageNo = null,
        int|null $limit = null,
    ): array {
        return $this->client->request(
            'globalmap/eventrating',
            [
                'event_id' => $eventId,
                'front_id' => $frontId,
                'fields' => $fields,
                'page_no' => $pageNo,
                'limit' => $limit,
            ],
            null,
        );
    }

    /**
     * globalmap/eventrating. Prepare without HTTP I/O.
     * @param list<string> $fields
     */
    public function prepareEventRating(
        string $eventId,
        string $frontId,
        array $fields = [],
        int|null $pageNo = null,
        int|null $limit = null,
    ): PreparedOperation {
        return $this->client->prepare(
            'globalmap/eventrating',
            [
                'event_id' => $eventId,
                'front_id' => $frontId,
                'fields' => $fields,
                'page_no' => $pageNo,
                'limit' => $limit,
            ],
            null,
        );
    }

    /**
     * globalmap/eventratingneighbors. Return one raw result per URL.
     * @param list<string> $fields
     * @return list<FetchResult>
     */
    public function eventRatingNeighbors(
        string $eventId,
        string $frontId,
        int $clanId,
        array $fields = [],
        int|null $limit = null,
    ): array {
        return $this->client->request(
            'globalmap/eventratingneighbors',
            [
                'event_id' => $eventId,
                'front_id' => $frontId,
                'clan_id' => $clanId,
                'fields' => $fields,
                'limit' => $limit,
            ],
            null,
        );
    }

    /**
     * globalmap/eventratingneighbors. Prepare without HTTP I/O.
     * @param list<string> $fields
     */
    public function prepareEventRatingNeighbors(
        string $eventId,
        string $frontId,
        int $clanId,
        array $fields = [],
        int|null $limit = null,
    ): PreparedOperation {
        return $this->client->prepare(
            'globalmap/eventratingneighbors',
            [
                'event_id' => $eventId,
                'front_id' => $frontId,
                'clan_id' => $clanId,
                'fields' => $fields,
                'limit' => $limit,
            ],
            null,
        );
    }

    /**
     * globalmap/info. Return one raw result per URL.
     * @param list<string> $fields
     * @return list<FetchResult>
     */
    public function info(
        array $fields = [],
    ): array {
        return $this->client->request(
            'globalmap/info',
            [
                'fields' => $fields,
            ],
            null,
        );
    }

    /**
     * globalmap/info. Prepare without HTTP I/O.
     * @param list<string> $fields
     */
    public function prepareInfo(
        array $fields = [],
    ): PreparedOperation {
        return $this->client->prepare(
            'globalmap/info',
            [
                'fields' => $fields,
            ],
            null,
        );
    }

}
