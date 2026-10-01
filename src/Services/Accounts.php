<?php

declare(strict_types=1);

namespace edrard\WotClient\Services;

use edrard\WotClient\PreparedOperation;
use edrard\WgGetter\FetchResult;
use SensitiveParameter;

/** Generated from resources/endpoints.json by tools/generate-client.mjs. */
final readonly class Accounts extends Service
{
    /**
     * account/list. Return one raw result per URL.
     * @param list<string> $fields
     * @return list<FetchResult>
     */
    public function search(
        string $search,
        string|null $language = null,
        array $fields = [],
        string|null $type = null,
        int|null $limit = null,
    ): array {
        return $this->client->request(
            'account/list',
            [
                'search' => $search,
                'language' => $language,
                'fields' => $fields,
                'type' => $type,
                'limit' => $limit,
            ],
            null,
        );
    }

    /**
     * account/list. Prepare without HTTP I/O.
     * @param list<string> $fields
     */
    public function prepareSearch(
        string $search,
        string|null $language = null,
        array $fields = [],
        string|null $type = null,
        int|null $limit = null,
    ): PreparedOperation {
        return $this->client->prepare(
            'account/list',
            [
                'search' => $search,
                'language' => $language,
                'fields' => $fields,
                'type' => $type,
                'limit' => $limit,
            ],
            null,
        );
    }

    /**
     * Split N exact nicknames into URL groups of caller-supplied K.
     * @param list<string> $names
     * @param list<string> $fields
     * @return list<FetchResult>
     */
    public function searchExactMany(
        array $names,
        int $batchSize,
        string|null $language = null,
        array $fields = [],
        int|null $limit = null,
    ): array {
        return $this->client->request(
            'account/list',
            ['search' => $names, 'type' => 'exact', 'language' => $language, 'fields' => $fields, 'limit' => $limit],
            $batchSize,
        );
    }

    /**
     * Split N exact nicknames into URL groups of caller-supplied K.
     * @param list<string> $names
     * @param list<string> $fields
     */
    public function prepareSearchExactMany(
        array $names,
        int $batchSize,
        string|null $language = null,
        array $fields = [],
        int|null $limit = null,
    ): PreparedOperation {
        return $this->client->prepare(
            'account/list',
            ['search' => $names, 'type' => 'exact', 'language' => $language, 'fields' => $fields, 'limit' => $limit],
            $batchSize,
        );
    }

    /**
     * account/info. Return one raw result per URL.
     * @param list<int> $accountIds
     * @param list<string> $fields
     * @param list<string> $extra
     * @return list<FetchResult>
     */
    public function info(
        array $accountIds,
        int $batchSize,
        string|null $language = null,
        array $fields = [],
        #[SensitiveParameter] string|null $accessToken = null,
        array $extra = [],
    ): array {
        return $this->client->request(
            'account/info',
            [
                'account_id' => $accountIds,
                'language' => $language,
                'fields' => $fields,
                'access_token' => $accessToken,
                'extra' => $extra,
            ],
            $batchSize,
        );
    }

    /**
     * account/info. Prepare without HTTP I/O.
     * @param list<int> $accountIds
     * @param list<string> $fields
     * @param list<string> $extra
     */
    public function prepareInfo(
        array $accountIds,
        int $batchSize,
        string|null $language = null,
        array $fields = [],
        #[SensitiveParameter] string|null $accessToken = null,
        array $extra = [],
    ): PreparedOperation {
        return $this->client->prepare(
            'account/info',
            [
                'account_id' => $accountIds,
                'language' => $language,
                'fields' => $fields,
                'access_token' => $accessToken,
                'extra' => $extra,
            ],
            $batchSize,
        );
    }

    /**
     * account/tanks. Return one raw result per URL.
     * @param list<int> $accountIds
     * @param list<string> $fields
     * @param list<int> $tankIds
     * @return list<FetchResult>
     */
    public function tanks(
        array $accountIds,
        int $batchSize,
        string|null $language = null,
        array $fields = [],
        #[SensitiveParameter] string|null $accessToken = null,
        array $tankIds = [],
    ): array {
        return $this->client->request(
            'account/tanks',
            [
                'account_id' => $accountIds,
                'language' => $language,
                'fields' => $fields,
                'access_token' => $accessToken,
                'tank_id' => $tankIds,
            ],
            $batchSize,
        );
    }

    /**
     * account/tanks. Prepare without HTTP I/O.
     * @param list<int> $accountIds
     * @param list<string> $fields
     * @param list<int> $tankIds
     */
    public function prepareTanks(
        array $accountIds,
        int $batchSize,
        string|null $language = null,
        array $fields = [],
        #[SensitiveParameter] string|null $accessToken = null,
        array $tankIds = [],
    ): PreparedOperation {
        return $this->client->prepare(
            'account/tanks',
            [
                'account_id' => $accountIds,
                'language' => $language,
                'fields' => $fields,
                'access_token' => $accessToken,
                'tank_id' => $tankIds,
            ],
            $batchSize,
        );
    }

    /**
     * account/achievements. Return one raw result per URL.
     * @param list<int> $accountIds
     * @param list<string> $fields
     * @return list<FetchResult>
     */
    public function achievements(
        array $accountIds,
        int $batchSize,
        string|null $language = null,
        array $fields = [],
    ): array {
        return $this->client->request(
            'account/achievements',
            [
                'account_id' => $accountIds,
                'language' => $language,
                'fields' => $fields,
            ],
            $batchSize,
        );
    }

    /**
     * account/achievements. Prepare without HTTP I/O.
     * @param list<int> $accountIds
     * @param list<string> $fields
     */
    public function prepareAchievements(
        array $accountIds,
        int $batchSize,
        string|null $language = null,
        array $fields = [],
    ): PreparedOperation {
        return $this->client->prepare(
            'account/achievements',
            [
                'account_id' => $accountIds,
                'language' => $language,
                'fields' => $fields,
            ],
            $batchSize,
        );
    }

    /**
     * account/wtr. Return one raw result per URL.
     * @param list<int> $accountIds
     * @param list<string> $fields
     * @return list<FetchResult>
     */
    public function wtr(
        array $accountIds,
        int $batchSize,
        string|null $language = null,
        array $fields = [],
    ): array {
        return $this->client->request(
            'account/wtr',
            [
                'account_id' => $accountIds,
                'language' => $language,
                'fields' => $fields,
            ],
            $batchSize,
        );
    }

    /**
     * account/wtr. Prepare without HTTP I/O.
     * @param list<int> $accountIds
     * @param list<string> $fields
     */
    public function prepareWtr(
        array $accountIds,
        int $batchSize,
        string|null $language = null,
        array $fields = [],
    ): PreparedOperation {
        return $this->client->prepare(
            'account/wtr',
            [
                'account_id' => $accountIds,
                'language' => $language,
                'fields' => $fields,
            ],
            $batchSize,
        );
    }

}
