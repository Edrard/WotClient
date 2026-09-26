<?php

declare(strict_types=1);

namespace edrard\WotClient\Facades;

use edrard\WgAuth\AccessToken;
use edrard\WotClient\ApiResult;
use edrard\WotClient\Record;
use Generator;
use SensitiveParameter;

/** Generated from resources/endpoints.json; regenerate with tools/generate-endpoints.py. */
final class Clans
{
    /**
     * clans/list; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     */
    public static function search(
        string|null $language = null,
        array $fields = [],
        string|null $search = null,
        int|null $limit = null,
        int|null $pageNo = null,
    ): ApiResult {
        return Wot::client()->clans()->search($language, $fields, $search, $limit, $pageNo);
    }

    /**
     * clans/list; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     * @return Generator<array-key, Record|null>
     */
    public static function iterateSearch(
        string|null $language = null,
        array $fields = [],
        string|null $search = null,
        int|null $limit = null,
        int $startPage = 1,
        int $maxPages = 1000,
    ): Generator {
        return Wot::client()->clans()->iterateSearch(
            $language,
            $fields,
            $search,
            $limit,
            $startPage,
            $maxPages,
        );
    }

    /**
     * clans/list; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     */
    public static function allSearch(
        string|null $language = null,
        array $fields = [],
        string|null $search = null,
        int|null $limit = null,
        int $startPage = 1,
        int $maxPages = 1000,
    ): ApiResult {
        return Wot::client()->clans()->allSearch($language, $fields, $search, $limit, $startPage, $maxPages);
    }

    /**
     * clans/info; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<int> $clanIds
     * @param list<string> $fields
     * @param list<string> $extra
     */
    public static function info(
        array $clanIds,
        string|null $language = null,
        array $fields = [],
        #[SensitiveParameter] AccessToken|null $accessToken = null,
        array $extra = [],
        string|null $membersKey = null,
    ): ApiResult {
        return Wot::client()->clans()->info($clanIds, $language, $fields, $accessToken, $extra, $membersKey);
    }

    /**
     * clans/accountinfo; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<int> $accountIds
     * @param list<string> $fields
     */
    public static function accountInfo(array $accountIds, string|null $language = null, array $fields = []): ApiResult
    {
        return Wot::client()->clans()->accountInfo($accountIds, $language, $fields);
    }

    /**
     * clans/glossary; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     */
    public static function glossary(string|null $language = null, array $fields = []): ApiResult
    {
        return Wot::client()->clans()->glossary($language, $fields);
    }

    /**
     * clans/messageboard; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     */
    public static function messageboard(#[SensitiveParameter] AccessToken $accessToken, array $fields = []): ApiResult
    {
        return Wot::client()->clans()->messageboard($accessToken, $fields);
    }

    /**
     * clans/memberhistory; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     */
    public static function memberHistory(int $accountId, string|null $language = null, array $fields = []): ApiResult
    {
        return Wot::client()->clans()->memberHistory($accountId, $language, $fields);
    }

}
