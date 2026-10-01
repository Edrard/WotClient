<?php

declare(strict_types=1);

namespace edrard\WotClient\Facades;

use edrard\WotClient\PreparedOperation;
use edrard\WgGetter\FetchResult;
use SensitiveParameter;

/** Generated from resources/endpoints.json by tools/generate-client.mjs. */
final class Clans
{
    /**
     * clans/list. Return one raw result per URL.
     * @param list<string> $fields
     * @return list<FetchResult>
     */
    public static function search(
        string|null $language = null,
        array $fields = [],
        string|null $search = null,
        int|null $limit = null,
        int|null $pageNo = null,
    ): array {
        return Wot::client()->clans()->search($language, $fields, $search, $limit, $pageNo);
    }

    /**
     * clans/list. Prepare without HTTP I/O.
     * @param list<string> $fields
     */
    public static function prepareSearch(
        string|null $language = null,
        array $fields = [],
        string|null $search = null,
        int|null $limit = null,
        int|null $pageNo = null,
    ): PreparedOperation {
        return Wot::client()->clans()->prepareSearch($language, $fields, $search, $limit, $pageNo);
    }

    /**
     * clans/info. Return one raw result per URL.
     * @param list<int> $clanIds
     * @param list<string> $fields
     * @param list<string> $extra
     * @return list<FetchResult>
     */
    public static function info(
        array $clanIds,
        int $batchSize,
        string|null $language = null,
        array $fields = [],
        #[SensitiveParameter] string|null $accessToken = null,
        array $extra = [],
        string|null $membersKey = null,
    ): array {
        return Wot::client()->clans()->info($clanIds, $batchSize, $language, $fields, $accessToken, $extra, $membersKey);
    }

    /**
     * clans/info. Prepare without HTTP I/O.
     * @param list<int> $clanIds
     * @param list<string> $fields
     * @param list<string> $extra
     */
    public static function prepareInfo(
        array $clanIds,
        int $batchSize,
        string|null $language = null,
        array $fields = [],
        #[SensitiveParameter] string|null $accessToken = null,
        array $extra = [],
        string|null $membersKey = null,
    ): PreparedOperation {
        return Wot::client()->clans()->prepareInfo($clanIds, $batchSize, $language, $fields, $accessToken, $extra, $membersKey);
    }

    /**
     * clans/accountinfo. Return one raw result per URL.
     * @param list<int> $accountIds
     * @param list<string> $fields
     * @return list<FetchResult>
     */
    public static function accountInfo(
        array $accountIds,
        int $batchSize,
        string|null $language = null,
        array $fields = [],
    ): array {
        return Wot::client()->clans()->accountInfo($accountIds, $batchSize, $language, $fields);
    }

    /**
     * clans/accountinfo. Prepare without HTTP I/O.
     * @param list<int> $accountIds
     * @param list<string> $fields
     */
    public static function prepareAccountInfo(
        array $accountIds,
        int $batchSize,
        string|null $language = null,
        array $fields = [],
    ): PreparedOperation {
        return Wot::client()->clans()->prepareAccountInfo($accountIds, $batchSize, $language, $fields);
    }

    /**
     * clans/glossary. Return one raw result per URL.
     * @param list<string> $fields
     * @return list<FetchResult>
     */
    public static function glossary(
        string|null $language = null,
        array $fields = [],
    ): array {
        return Wot::client()->clans()->glossary($language, $fields);
    }

    /**
     * clans/glossary. Prepare without HTTP I/O.
     * @param list<string> $fields
     */
    public static function prepareGlossary(
        string|null $language = null,
        array $fields = [],
    ): PreparedOperation {
        return Wot::client()->clans()->prepareGlossary($language, $fields);
    }

    /**
     * clans/messageboard. Return one raw result per URL.
     * @param list<string> $fields
     * @return list<FetchResult>
     */
    public static function messageboard(
        #[SensitiveParameter] string $accessToken,
        array $fields = [],
    ): array {
        return Wot::client()->clans()->messageboard($accessToken, $fields);
    }

    /**
     * clans/messageboard. Prepare without HTTP I/O.
     * @param list<string> $fields
     */
    public static function prepareMessageboard(
        #[SensitiveParameter] string $accessToken,
        array $fields = [],
    ): PreparedOperation {
        return Wot::client()->clans()->prepareMessageboard($accessToken, $fields);
    }

    /**
     * clans/memberhistory. Return one raw result per URL.
     * @param list<string> $fields
     * @return list<FetchResult>
     */
    public static function memberHistory(
        int $accountId,
        string|null $language = null,
        array $fields = [],
    ): array {
        return Wot::client()->clans()->memberHistory($accountId, $language, $fields);
    }

    /**
     * clans/memberhistory. Prepare without HTTP I/O.
     * @param list<string> $fields
     */
    public static function prepareMemberHistory(
        int $accountId,
        string|null $language = null,
        array $fields = [],
    ): PreparedOperation {
        return Wot::client()->clans()->prepareMemberHistory($accountId, $language, $fields);
    }

}
