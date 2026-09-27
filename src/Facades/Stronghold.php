<?php

declare(strict_types=1);

namespace edrard\WotClient\Facades;

use edrard\WgAuth\AccessToken;
use edrard\WotClient\ApiResult;
use edrard\WotClient\PreparedOperation;
use edrard\WotClient\Record;
use Generator;
use SensitiveParameter;

/** Generated from resources/endpoints.json; regenerate with tools/generate-endpoints.py. */
final class Stronghold
{
    /**
     * stronghold/claninfo; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<int> $clanIds
     * @param list<string> $fields
     */
    public static function clanInfo(array $clanIds, array $fields = [], string|null $language = null): ApiResult
    {
        return Wot::client()->stronghold()->clanInfo($clanIds, $fields, $language);
    }

    /**
     * stronghold/claninfo; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<int> $clanIds
     * @param list<string> $fields
     */
    public static function prepareClanInfo(array $clanIds, array $fields = [], string|null $language = null): PreparedOperation
    {
        return Wot::client()->stronghold()->prepareClanInfo($clanIds, $fields, $language);
    }

    /**
     * stronghold/clanreserves; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     */
    public static function clanReserves(
        #[SensitiveParameter] AccessToken $accessToken,
        array $fields = [],
        string|null $language = null,
    ): ApiResult {
        return Wot::client()->stronghold()->clanReserves($accessToken, $fields, $language);
    }

    /**
     * stronghold/clanreserves; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     */
    public static function prepareClanReserves(
        #[SensitiveParameter] AccessToken $accessToken,
        array $fields = [],
        string|null $language = null,
    ): PreparedOperation {
        return Wot::client()->stronghold()->prepareClanReserves($accessToken, $fields, $language);
    }

    /**
     * stronghold/activateclanreserve; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     * Activates a real clan reserve. No automatic retries; a timeout has an unknown outcome.
     */
    public static function activateClanReserve(
        #[SensitiveParameter] AccessToken $accessToken,
        string $reserveType,
        int $reserveLevel,
        array $fields = [],
        string|null $language = null,
    ): ApiResult {
        return Wot::client()->stronghold()->activateClanReserve(
            $accessToken,
            $reserveType,
            $reserveLevel,
            $fields,
            $language,
        );
    }

}
