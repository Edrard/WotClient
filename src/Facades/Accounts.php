<?php

declare(strict_types=1);

namespace edrard\WotClient\Facades;

use edrard\WotClient\PreparedOperation;
use edrard\WgGetter\FetchResult;
use SensitiveParameter;

/** Generated from resources/endpoints.json by tools/generate-client.mjs. */
final class Accounts
{
    /**
     * account/list. Return one raw result per URL.
     * @param list<string> $fields
     * @return list<FetchResult>
     */
    public static function search(
        string $search,
        string|null $language = null,
        array $fields = [],
        string|null $type = null,
        int|null $limit = null,
    ): array {
        return Wot::client()->accounts()->search($search, $language, $fields, $type, $limit);
    }

    /**
     * account/list. Prepare without HTTP I/O.
     * @param list<string> $fields
     */
    public static function prepareSearch(
        string $search,
        string|null $language = null,
        array $fields = [],
        string|null $type = null,
        int|null $limit = null,
    ): PreparedOperation {
        return Wot::client()->accounts()->prepareSearch($search, $language, $fields, $type, $limit);
    }

    /**
     * Split N exact nicknames into URL groups of caller-supplied K.
     * @param list<string> $names
     * @param list<string> $fields
     * @return list<FetchResult>
     */
    public static function searchExactMany(
        array $names,
        int $batchSize,
        string|null $language = null,
        array $fields = [],
        int|null $limit = null,
    ): array {
        return Wot::client()->accounts()->searchExactMany($names, $batchSize, $language, $fields, $limit);
    }

    /**
     * Split N exact nicknames into URL groups of caller-supplied K.
     * @param list<string> $names
     * @param list<string> $fields
     */
    public static function prepareSearchExactMany(
        array $names,
        int $batchSize,
        string|null $language = null,
        array $fields = [],
        int|null $limit = null,
    ): PreparedOperation {
        return Wot::client()->accounts()->prepareSearchExactMany($names, $batchSize, $language, $fields, $limit);
    }

    /**
     * account/info. Return one raw result per URL.
     * @param list<int> $accountIds
     * @param list<string> $fields
     * @param list<string> $extra
     * @return list<FetchResult>
     */
    public static function info(
        array $accountIds,
        int $batchSize,
        string|null $language = null,
        array $fields = [],
        #[SensitiveParameter] string|null $accessToken = null,
        array $extra = [],
    ): array {
        return Wot::client()->accounts()->info($accountIds, $batchSize, $language, $fields, $accessToken, $extra);
    }

    /**
     * account/info. Prepare without HTTP I/O.
     * @param list<int> $accountIds
     * @param list<string> $fields
     * @param list<string> $extra
     */
    public static function prepareInfo(
        array $accountIds,
        int $batchSize,
        string|null $language = null,
        array $fields = [],
        #[SensitiveParameter] string|null $accessToken = null,
        array $extra = [],
    ): PreparedOperation {
        return Wot::client()->accounts()->prepareInfo($accountIds, $batchSize, $language, $fields, $accessToken, $extra);
    }

    /**
     * account/tanks. Return one raw result per URL.
     * @param list<int> $accountIds
     * @param list<string> $fields
     * @param list<int> $tankIds
     * @return list<FetchResult>
     */
    public static function tanks(
        array $accountIds,
        int $batchSize,
        string|null $language = null,
        array $fields = [],
        #[SensitiveParameter] string|null $accessToken = null,
        array $tankIds = [],
    ): array {
        return Wot::client()->accounts()->tanks($accountIds, $batchSize, $language, $fields, $accessToken, $tankIds);
    }

    /**
     * account/tanks. Prepare without HTTP I/O.
     * @param list<int> $accountIds
     * @param list<string> $fields
     * @param list<int> $tankIds
     */
    public static function prepareTanks(
        array $accountIds,
        int $batchSize,
        string|null $language = null,
        array $fields = [],
        #[SensitiveParameter] string|null $accessToken = null,
        array $tankIds = [],
    ): PreparedOperation {
        return Wot::client()->accounts()->prepareTanks($accountIds, $batchSize, $language, $fields, $accessToken, $tankIds);
    }

    /**
     * account/achievements. Return one raw result per URL.
     * @param list<int> $accountIds
     * @param list<string> $fields
     * @return list<FetchResult>
     */
    public static function achievements(
        array $accountIds,
        int $batchSize,
        string|null $language = null,
        array $fields = [],
    ): array {
        return Wot::client()->accounts()->achievements($accountIds, $batchSize, $language, $fields);
    }

    /**
     * account/achievements. Prepare without HTTP I/O.
     * @param list<int> $accountIds
     * @param list<string> $fields
     */
    public static function prepareAchievements(
        array $accountIds,
        int $batchSize,
        string|null $language = null,
        array $fields = [],
    ): PreparedOperation {
        return Wot::client()->accounts()->prepareAchievements($accountIds, $batchSize, $language, $fields);
    }

    /**
     * account/wtr. Return one raw result per URL.
     * @param list<int> $accountIds
     * @param list<string> $fields
     * @return list<FetchResult>
     */
    public static function wtr(
        array $accountIds,
        int $batchSize,
        string|null $language = null,
        array $fields = [],
    ): array {
        return Wot::client()->accounts()->wtr($accountIds, $batchSize, $language, $fields);
    }

    /**
     * account/wtr. Prepare without HTTP I/O.
     * @param list<int> $accountIds
     * @param list<string> $fields
     */
    public static function prepareWtr(
        array $accountIds,
        int $batchSize,
        string|null $language = null,
        array $fields = [],
    ): PreparedOperation {
        return Wot::client()->accounts()->prepareWtr($accountIds, $batchSize, $language, $fields);
    }

}
