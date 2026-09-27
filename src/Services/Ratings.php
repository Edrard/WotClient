<?php

declare(strict_types=1);

namespace edrard\WotClient\Services;

use edrard\WgAuth\AccessToken;
use edrard\WotClient\ApiResult;
use edrard\WotClient\PreparedOperation;
use edrard\WotClient\Record;
use Generator;
use SensitiveParameter;

/** Generated from resources/endpoints.json; regenerate with tools/generate-endpoints.py. */
final readonly class Ratings extends Service
{
    /**
     * ratings/types; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     * @deprecated WG marks this endpoint deprecated; requires explicit client opt-in.
     */
    public function types(string|null $language = null, array $fields = [], string|null $battleType = null): ApiResult
    {
        return $this->client->request(
            'ratings/types',
            [
                'language' => $language,
                'fields' => $fields,
                'battle_type' => $battleType,
            ],
            null,
        );
    }

    /**
     * ratings/types; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     * @deprecated WG marks this endpoint deprecated; requires explicit client opt-in.
     */
    public function prepareTypes(
        string|null $language = null,
        array $fields = [],
        string|null $battleType = null,
    ): PreparedOperation {
        return $this->client->prepare(
            'ratings/types',
            [
                'language' => $language,
                'fields' => $fields,
                'battle_type' => $battleType,
            ],
            null,
        );
    }

    /**
     * ratings/dates; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     * @param list<int> $accountIds
     * @deprecated WG marks this endpoint deprecated; requires explicit client opt-in.
     */
    public function dates(
        string $type,
        string|null $language = null,
        array $fields = [],
        string|null $battleType = null,
        array $accountIds = [],
    ): ApiResult {
        return $this->client->request(
            'ratings/dates',
            [
                'type' => $type,
                'language' => $language,
                'fields' => $fields,
                'battle_type' => $battleType,
                'account_id' => $accountIds,
            ],
            null,
        );
    }

    /**
     * ratings/dates; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     * @param list<int> $accountIds
     * @deprecated WG marks this endpoint deprecated; requires explicit client opt-in.
     */
    public function prepareDates(
        string $type,
        string|null $language = null,
        array $fields = [],
        string|null $battleType = null,
        array $accountIds = [],
    ): PreparedOperation {
        return $this->client->prepare(
            'ratings/dates',
            [
                'type' => $type,
                'language' => $language,
                'fields' => $fields,
                'battle_type' => $battleType,
                'account_id' => $accountIds,
            ],
            null,
        );
    }

    /**
     * ratings/accounts; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<int> $accountIds
     * @param list<string> $fields
     * @deprecated WG marks this endpoint deprecated; requires explicit client opt-in.
     */
    public function accounts(
        string $type,
        array $accountIds,
        string|null $language = null,
        array $fields = [],
        string|null $battleType = null,
        int|string|null $date = null,
    ): ApiResult {
        return $this->client->request(
            'ratings/accounts',
            [
                'type' => $type,
                'account_id' => $accountIds,
                'language' => $language,
                'fields' => $fields,
                'battle_type' => $battleType,
                'date' => $date,
            ],
            null,
        );
    }

    /**
     * ratings/accounts; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<int> $accountIds
     * @param list<string> $fields
     * @deprecated WG marks this endpoint deprecated; requires explicit client opt-in.
     */
    public function prepareAccounts(
        string $type,
        array $accountIds,
        string|null $language = null,
        array $fields = [],
        string|null $battleType = null,
        int|string|null $date = null,
    ): PreparedOperation {
        return $this->client->prepare(
            'ratings/accounts',
            [
                'type' => $type,
                'account_id' => $accountIds,
                'language' => $language,
                'fields' => $fields,
                'battle_type' => $battleType,
                'date' => $date,
            ],
            null,
        );
    }

    /**
     * ratings/neighbors; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     * @deprecated WG marks this endpoint deprecated; requires explicit client opt-in.
     */
    public function neighbors(
        string $type,
        int $accountId,
        string $rankField,
        string|null $language = null,
        array $fields = [],
        string|null $battleType = null,
        int|string|null $date = null,
        int|null $limit = null,
    ): ApiResult {
        return $this->client->request(
            'ratings/neighbors',
            [
                'type' => $type,
                'account_id' => $accountId,
                'rank_field' => $rankField,
                'language' => $language,
                'fields' => $fields,
                'battle_type' => $battleType,
                'date' => $date,
                'limit' => $limit,
            ],
            null,
        );
    }

    /**
     * ratings/neighbors; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     * @deprecated WG marks this endpoint deprecated; requires explicit client opt-in.
     */
    public function prepareNeighbors(
        string $type,
        int $accountId,
        string $rankField,
        string|null $language = null,
        array $fields = [],
        string|null $battleType = null,
        int|string|null $date = null,
        int|null $limit = null,
    ): PreparedOperation {
        return $this->client->prepare(
            'ratings/neighbors',
            [
                'type' => $type,
                'account_id' => $accountId,
                'rank_field' => $rankField,
                'language' => $language,
                'fields' => $fields,
                'battle_type' => $battleType,
                'date' => $date,
                'limit' => $limit,
            ],
            null,
        );
    }

    /**
     * ratings/top; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     * @deprecated WG marks this endpoint deprecated; requires explicit client opt-in.
     */
    public function top(
        string $type,
        string $rankField,
        string|null $language = null,
        array $fields = [],
        string|null $battleType = null,
        int|string|null $date = null,
        int|null $limit = null,
        int|null $pageNo = null,
    ): ApiResult {
        return $this->client->request(
            'ratings/top',
            [
                'type' => $type,
                'rank_field' => $rankField,
                'language' => $language,
                'fields' => $fields,
                'battle_type' => $battleType,
                'date' => $date,
                'limit' => $limit,
                'page_no' => $pageNo,
            ],
            null,
        );
    }

    /**
     * ratings/top; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     * @deprecated WG marks this endpoint deprecated; requires explicit client opt-in.
     */
    public function prepareTop(
        string $type,
        string $rankField,
        string|null $language = null,
        array $fields = [],
        string|null $battleType = null,
        int|string|null $date = null,
        int|null $limit = null,
        int|null $pageNo = null,
    ): PreparedOperation {
        return $this->client->prepare(
            'ratings/top',
            [
                'type' => $type,
                'rank_field' => $rankField,
                'language' => $language,
                'fields' => $fields,
                'battle_type' => $battleType,
                'date' => $date,
                'limit' => $limit,
                'page_no' => $pageNo,
            ],
            null,
        );
    }

    /**
     * ratings/top; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     * @return Generator<array-key, Record|null>
     * @deprecated WG marks this endpoint deprecated; requires explicit client opt-in.
     */
    public function iterateTop(
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
        return $this->client->iterate(
            'ratings/top',
            [
                'type' => $type,
                'rank_field' => $rankField,
                'language' => $language,
                'fields' => $fields,
                'battle_type' => $battleType,
                'date' => $date,
                'limit' => $limit,
            ],
            null,
            $startPage,
            $maxPages,
        );
    }

    /**
     * ratings/top; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     * @deprecated WG marks this endpoint deprecated; requires explicit client opt-in.
     */
    public function allTop(
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
        return $this->client->all(
            'ratings/top',
            [
                'type' => $type,
                'rank_field' => $rankField,
                'language' => $language,
                'fields' => $fields,
                'battle_type' => $battleType,
                'date' => $date,
                'limit' => $limit,
            ],
            null,
            $startPage,
            $maxPages,
        );
    }

}
