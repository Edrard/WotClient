<?php

declare(strict_types=1);

namespace edrard\WotClient\Services;

use edrard\WotClient\PreparedOperation;
use edrard\WgGetter\FetchResult;
use SensitiveParameter;

/** Generated from resources/endpoints.json by tools/generate-client.mjs. */
final readonly class Ratings extends Service
{
    /**
     * ratings/types. Return one raw result per URL.
     * @deprecated Marked deprecated in the WG catalog; requests remain available.
     * @param list<string> $fields
     * @return list<FetchResult>
     */
    public function types(
        string|null $language = null,
        array $fields = [],
        string|null $battleType = null,
    ): array {
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
     * ratings/types. Prepare without HTTP I/O.
     * @deprecated Marked deprecated in the WG catalog; requests remain available.
     * @param list<string> $fields
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
     * ratings/dates. Return one raw result per URL.
     * @deprecated Marked deprecated in the WG catalog; requests remain available.
     * @param list<string> $fields
     * @param list<int> $accountIds
     * @return list<FetchResult>
     */
    public function dates(
        string $type,
        string|null $language = null,
        array $fields = [],
        string|null $battleType = null,
        array $accountIds = [],
    ): array {
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
     * ratings/dates. Prepare without HTTP I/O.
     * @deprecated Marked deprecated in the WG catalog; requests remain available.
     * @param list<string> $fields
     * @param list<int> $accountIds
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
     * ratings/accounts. Return one raw result per URL.
     * @deprecated Marked deprecated in the WG catalog; requests remain available.
     * @param list<int> $accountIds
     * @param list<string> $fields
     * @return list<FetchResult>
     */
    public function accounts(
        string $type,
        array $accountIds,
        int $batchSize,
        string|null $language = null,
        array $fields = [],
        string|null $battleType = null,
        int|string|null $date = null,
    ): array {
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
            $batchSize,
        );
    }

    /**
     * ratings/accounts. Prepare without HTTP I/O.
     * @deprecated Marked deprecated in the WG catalog; requests remain available.
     * @param list<int> $accountIds
     * @param list<string> $fields
     */
    public function prepareAccounts(
        string $type,
        array $accountIds,
        int $batchSize,
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
            $batchSize,
        );
    }

    /**
     * ratings/neighbors. Return one raw result per URL.
     * @deprecated Marked deprecated in the WG catalog; requests remain available.
     * @param list<string> $fields
     * @return list<FetchResult>
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
    ): array {
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
     * ratings/neighbors. Prepare without HTTP I/O.
     * @deprecated Marked deprecated in the WG catalog; requests remain available.
     * @param list<string> $fields
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
     * ratings/top. Return one raw result per URL.
     * @deprecated Marked deprecated in the WG catalog; requests remain available.
     * @param list<string> $fields
     * @return list<FetchResult>
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
    ): array {
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
     * ratings/top. Prepare without HTTP I/O.
     * @deprecated Marked deprecated in the WG catalog; requests remain available.
     * @param list<string> $fields
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

}
