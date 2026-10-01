<?php

declare(strict_types=1);

namespace edrard\WotClient\Services;

use edrard\WotClient\PreparedOperation;
use edrard\WgGetter\FetchResult;
use SensitiveParameter;

/** Generated from resources/endpoints.json by tools/generate-client.mjs. */
final readonly class Clans extends Service
{
    /**
     * clans/list. Return one raw result per URL.
     * @param list<string> $fields
     * @return list<FetchResult>
     */
    public function search(
        string|null $language = null,
        array $fields = [],
        string|null $search = null,
        int|null $limit = null,
        int|null $pageNo = null,
    ): array {
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
     * clans/list. Prepare without HTTP I/O.
     * @param list<string> $fields
     */
    public function prepareSearch(
        string|null $language = null,
        array $fields = [],
        string|null $search = null,
        int|null $limit = null,
        int|null $pageNo = null,
    ): PreparedOperation {
        return $this->client->prepare(
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
     * clans/info. Return one raw result per URL.
     * @param list<int> $clanIds
     * @param list<string> $fields
     * @param list<string> $extra
     * @return list<FetchResult>
     */
    public function info(
        array $clanIds,
        int $batchSize,
        string|null $language = null,
        array $fields = [],
        #[SensitiveParameter] string|null $accessToken = null,
        array $extra = [],
        string|null $membersKey = null,
    ): array {
        return $this->client->request(
            'clans/info',
            [
                'clan_id' => $clanIds,
                'language' => $language,
                'fields' => $fields,
                'access_token' => $accessToken,
                'extra' => $extra,
                'members_key' => $membersKey,
            ],
            $batchSize,
        );
    }

    /**
     * clans/info. Prepare without HTTP I/O.
     * @param list<int> $clanIds
     * @param list<string> $fields
     * @param list<string> $extra
     */
    public function prepareInfo(
        array $clanIds,
        int $batchSize,
        string|null $language = null,
        array $fields = [],
        #[SensitiveParameter] string|null $accessToken = null,
        array $extra = [],
        string|null $membersKey = null,
    ): PreparedOperation {
        return $this->client->prepare(
            'clans/info',
            [
                'clan_id' => $clanIds,
                'language' => $language,
                'fields' => $fields,
                'access_token' => $accessToken,
                'extra' => $extra,
                'members_key' => $membersKey,
            ],
            $batchSize,
        );
    }

    /**
     * clans/accountinfo. Return one raw result per URL.
     * @param list<int> $accountIds
     * @param list<string> $fields
     * @return list<FetchResult>
     */
    public function accountInfo(
        array $accountIds,
        int $batchSize,
        string|null $language = null,
        array $fields = [],
    ): array {
        return $this->client->request(
            'clans/accountinfo',
            [
                'account_id' => $accountIds,
                'language' => $language,
                'fields' => $fields,
            ],
            $batchSize,
        );
    }

    /**
     * clans/accountinfo. Prepare without HTTP I/O.
     * @param list<int> $accountIds
     * @param list<string> $fields
     */
    public function prepareAccountInfo(
        array $accountIds,
        int $batchSize,
        string|null $language = null,
        array $fields = [],
    ): PreparedOperation {
        return $this->client->prepare(
            'clans/accountinfo',
            [
                'account_id' => $accountIds,
                'language' => $language,
                'fields' => $fields,
            ],
            $batchSize,
        );
    }

    /**
     * clans/glossary. Return one raw result per URL.
     * @param list<string> $fields
     * @return list<FetchResult>
     */
    public function glossary(
        string|null $language = null,
        array $fields = [],
    ): array {
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
     * clans/glossary. Prepare without HTTP I/O.
     * @param list<string> $fields
     */
    public function prepareGlossary(
        string|null $language = null,
        array $fields = [],
    ): PreparedOperation {
        return $this->client->prepare(
            'clans/glossary',
            [
                'language' => $language,
                'fields' => $fields,
            ],
            null,
        );
    }

    /**
     * clans/messageboard. Return one raw result per URL.
     * @param list<string> $fields
     * @return list<FetchResult>
     */
    public function messageboard(
        #[SensitiveParameter] string $accessToken,
        array $fields = [],
    ): array {
        return $this->client->request(
            'clans/messageboard',
            [
                'access_token' => $accessToken,
                'fields' => $fields,
            ],
            null,
        );
    }

    /**
     * clans/messageboard. Prepare without HTTP I/O.
     * @param list<string> $fields
     */
    public function prepareMessageboard(
        #[SensitiveParameter] string $accessToken,
        array $fields = [],
    ): PreparedOperation {
        return $this->client->prepare(
            'clans/messageboard',
            [
                'access_token' => $accessToken,
                'fields' => $fields,
            ],
            null,
        );
    }

    /**
     * clans/memberhistory. Return one raw result per URL.
     * @param list<string> $fields
     * @return list<FetchResult>
     */
    public function memberHistory(
        int $accountId,
        string|null $language = null,
        array $fields = [],
    ): array {
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

    /**
     * clans/memberhistory. Prepare without HTTP I/O.
     * @param list<string> $fields
     */
    public function prepareMemberHistory(
        int $accountId,
        string|null $language = null,
        array $fields = [],
    ): PreparedOperation {
        return $this->client->prepare(
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
