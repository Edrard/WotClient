<?php

declare(strict_types=1);

namespace edrard\WotClient\Services;

use edrard\WgAuth\AccessToken;
use edrard\WotClient\ApiResult;
use edrard\WotClient\Record;
use Generator;
use SensitiveParameter;

/** Generated from resources/endpoints.json; regenerate with tools/generate-endpoints.py. */
final readonly class Accounts extends Service
{
    /**
     * account/list; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     */
    public function search(
        string $search,
        string|null $language = null,
        array $fields = [],
        string|null $type = null,
        int|null $limit = null,
    ): ApiResult {
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
     * account/info; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<int> $accountIds
     * @param list<string> $fields
     * @param list<string> $extra
     */
    public function info(
        array $accountIds,
        string|null $language = null,
        array $fields = [],
        #[SensitiveParameter] AccessToken|null $accessToken = null,
        array $extra = [],
    ): ApiResult {
        return $this->client->request(
            'account/info',
            [
                'account_id' => $accountIds,
                'language' => $language,
                'fields' => $fields,
                'extra' => $extra,
            ],
            $accessToken,
        );
    }

    /**
     * account/tanks; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<int> $accountIds
     * @param list<string> $fields
     * @param list<int> $tankIds
     */
    public function tanks(
        array $accountIds,
        string|null $language = null,
        array $fields = [],
        #[SensitiveParameter] AccessToken|null $accessToken = null,
        array $tankIds = [],
    ): ApiResult {
        return $this->client->request(
            'account/tanks',
            [
                'account_id' => $accountIds,
                'language' => $language,
                'fields' => $fields,
                'tank_id' => $tankIds,
            ],
            $accessToken,
        );
    }

    /**
     * account/achievements; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<int> $accountIds
     * @param list<string> $fields
     */
    public function achievements(array $accountIds, string|null $language = null, array $fields = []): ApiResult
    {
        return $this->client->request(
            'account/achievements',
            [
                'account_id' => $accountIds,
                'language' => $language,
                'fields' => $fields,
            ],
            null,
        );
    }

    /**
     * account/wtr; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<int> $accountIds
     * @param list<string> $fields
     */
    public function wtr(array $accountIds, string|null $language = null, array $fields = []): ApiResult
    {
        return $this->client->request(
            'account/wtr',
            [
                'account_id' => $accountIds,
                'language' => $language,
                'fields' => $fields,
            ],
            null,
        );
    }

}
