<?php

declare(strict_types=1);

namespace edrard\WotClient\Facades;

use edrard\WgAuth\AccessToken;
use edrard\WotClient\ApiResult;
use edrard\WotClient\Record;
use Generator;
use SensitiveParameter;

/** Generated from resources/endpoints.json; regenerate with tools/generate-endpoints.py. */
final class Accounts
{
    /**
     * account/list; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     */
    public static function search(
        string $search,
        string|null $language = null,
        array $fields = [],
        string|null $type = null,
        int|null $limit = null,
    ): ApiResult {
        return Wot::client()->accounts()->search($search, $language, $fields, $type, $limit);
    }

    /**
     * account/info; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<int> $accountIds
     * @param list<string> $fields
     * @param list<string> $extra
     */
    public static function info(
        array $accountIds,
        string|null $language = null,
        array $fields = [],
        #[SensitiveParameter] AccessToken|null $accessToken = null,
        array $extra = [],
    ): ApiResult {
        return Wot::client()->accounts()->info($accountIds, $language, $fields, $accessToken, $extra);
    }

    /**
     * account/tanks; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<int> $accountIds
     * @param list<string> $fields
     * @param list<int> $tankIds
     */
    public static function tanks(
        array $accountIds,
        string|null $language = null,
        array $fields = [],
        #[SensitiveParameter] AccessToken|null $accessToken = null,
        array $tankIds = [],
    ): ApiResult {
        return Wot::client()->accounts()->tanks($accountIds, $language, $fields, $accessToken, $tankIds);
    }

    /**
     * account/achievements; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<int> $accountIds
     * @param list<string> $fields
     */
    public static function achievements(array $accountIds, string|null $language = null, array $fields = []): ApiResult
    {
        return Wot::client()->accounts()->achievements($accountIds, $language, $fields);
    }

    /**
     * account/wtr; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<int> $accountIds
     * @param list<string> $fields
     */
    public static function wtr(array $accountIds, string|null $language = null, array $fields = []): ApiResult
    {
        return Wot::client()->accounts()->wtr($accountIds, $language, $fields);
    }

}
