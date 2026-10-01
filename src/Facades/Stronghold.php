<?php

declare(strict_types=1);

namespace edrard\WotClient\Facades;

use edrard\WotClient\PreparedOperation;
use edrard\WgGetter\FetchResult;
use SensitiveParameter;

/** Generated from resources/endpoints.json by tools/generate-client.mjs. */
final class Stronghold
{
    /**
     * stronghold/claninfo. Return one raw result per URL.
     * @param list<int> $clanIds
     * @param list<string> $fields
     * @return list<FetchResult>
     */
    public static function clanInfo(
        array $clanIds,
        int $batchSize,
        array $fields = [],
        string|null $language = null,
    ): array {
        return Wot::client()->stronghold()->clanInfo($clanIds, $batchSize, $fields, $language);
    }

    /**
     * stronghold/claninfo. Prepare without HTTP I/O.
     * @param list<int> $clanIds
     * @param list<string> $fields
     */
    public static function prepareClanInfo(
        array $clanIds,
        int $batchSize,
        array $fields = [],
        string|null $language = null,
    ): PreparedOperation {
        return Wot::client()->stronghold()->prepareClanInfo($clanIds, $batchSize, $fields, $language);
    }

    /**
     * stronghold/clanreserves. Return one raw result per URL.
     * @param list<string> $fields
     * @return list<FetchResult>
     */
    public static function clanReserves(
        #[SensitiveParameter] string $accessToken,
        array $fields = [],
        string|null $language = null,
    ): array {
        return Wot::client()->stronghold()->clanReserves($accessToken, $fields, $language);
    }

    /**
     * stronghold/clanreserves. Prepare without HTTP I/O.
     * @param list<string> $fields
     */
    public static function prepareClanReserves(
        #[SensitiveParameter] string $accessToken,
        array $fields = [],
        string|null $language = null,
    ): PreparedOperation {
        return Wot::client()->stronghold()->prepareClanReserves($accessToken, $fields, $language);
    }

}
