<?php

declare(strict_types=1);

namespace edrard\WotClient\Services;

use edrard\WgAuth\AccessToken;
use edrard\WotClient\ApiResult;
use edrard\WotClient\Record;
use Generator;
use SensitiveParameter;

/** Generated from resources/endpoints.json; regenerate with tools/generate-endpoints.py. */
final readonly class Clans extends Service
{
    /**
     * clans/list; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     */
    public function search(
        string|null $language = null,
        array $fields = [],
        string|null $search = null,
        int|null $limit = null,
        int|null $pageNo = null,
    ): ApiResult {
        return $this->client->request(
            'clans/list',
            [
                'language' => $language,
                'fields' => $fields,
                'search' => $search,
                'limit' => $limit,
                'page_no' => $pageNo,
            ],
            null,
        );
    }

    /**
     * clans/list; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     * @return Generator<array-key, Record|null>
     */
    public function iterateSearch(
        string|null $language = null,
        array $fields = [],
        string|null $search = null,
        int|null $limit = null,
        int $startPage = 1,
        int $maxPages = 1000,
    ): Generator {
        return $this->client->iterate(
            'clans/list',
            [
                'language' => $language,
                'fields' => $fields,
                'search' => $search,
                'limit' => $limit,
            ],
            null,
            $startPage,
            $maxPages,
        );
    }

    /**
     * clans/list; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     */
    public function allSearch(
        string|null $language = null,
        array $fields = [],
        string|null $search = null,
        int|null $limit = null,
        int $startPage = 1,
        int $maxPages = 1000,
    ): ApiResult {
        return $this->client->all(
            'clans/list',
            [
                'language' => $language,
                'fields' => $fields,
                'search' => $search,
                'limit' => $limit,
            ],
            null,
            $startPage,
            $maxPages,
        );
    }

    /**
     * clans/info; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<int> $clanIds
     * @param list<string> $fields
     * @param list<string> $extra
     */
    public function info(
        array $clanIds,
        string|null $language = null,
        array $fields = [],
        #[SensitiveParameter] AccessToken|null $accessToken = null,
        array $extra = [],
        string|null $membersKey = null,
    ): ApiResult {
        return $this->client->request(
            'clans/info',
            [
                'clan_id' => $clanIds,
                'language' => $language,
                'fields' => $fields,
                'extra' => $extra,
                'members_key' => $membersKey,
            ],
            $accessToken,
        );
    }

    /**
     * clans/accountinfo; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<int> $accountIds
     * @param list<string> $fields
     */
    public function accountInfo(array $accountIds, string|null $language = null, array $fields = []): ApiResult
    {
        return $this->client->request(
            'clans/accountinfo',
            [
                'account_id' => $accountIds,
                'language' => $language,
                'fields' => $fields,
            ],
            null,
        );
    }

    /**
     * clans/glossary; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     */
    public function glossary(string|null $language = null, array $fields = []): ApiResult
    {
        return $this->client->request(
            'clans/glossary',
            [
                'language' => $language,
                'fields' => $fields,
            ],
            null,
        );
    }

    /**
     * clans/messageboard; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     */
    public function messageboard(#[SensitiveParameter] AccessToken $accessToken, array $fields = []): ApiResult
    {
        return $this->client->request(
            'clans/messageboard',
            [
                'fields' => $fields,
            ],
            $accessToken,
        );
    }

    /**
     * clans/memberhistory; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     */
    public function memberHistory(int $accountId, string|null $language = null, array $fields = []): ApiResult
    {
        return $this->client->request(
            'clans/memberhistory',
            [
                'account_id' => $accountId,
                'language' => $language,
                'fields' => $fields,
            ],
            null,
        );
    }

}
