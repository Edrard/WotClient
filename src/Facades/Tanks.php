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
final class Tanks
{
    /**
     * tanks/stats; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     * @param list<string> $extra
     * @param list<int> $tankIds
     */
    public static function stats(
        int $accountId,
        string|null $language = null,
        array $fields = [],
        #[SensitiveParameter] AccessToken|null $accessToken = null,
        array $extra = [],
        array $tankIds = [],
        string|null $inGarage = null,
    ): ApiResult {
        return Wot::client()->tanks()->stats(
            $accountId,
            $language,
            $fields,
            $accessToken,
            $extra,
            $tankIds,
            $inGarage,
        );
    }

    /**
     * tanks/stats; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     * @param list<string> $extra
     * @param list<int> $tankIds
     */
    public static function prepareStats(
        int $accountId,
        string|null $language = null,
        array $fields = [],
        #[SensitiveParameter] AccessToken|null $accessToken = null,
        array $extra = [],
        array $tankIds = [],
        string|null $inGarage = null,
    ): PreparedOperation {
        return Wot::client()->tanks()->prepareStats(
            $accountId,
            $language,
            $fields,
            $accessToken,
            $extra,
            $tankIds,
            $inGarage,
        );
    }

    /**
     * tanks/achievements; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     * @param list<int> $tankIds
     */
    public static function achievements(
        int $accountId,
        string|null $language = null,
        array $fields = [],
        #[SensitiveParameter] AccessToken|null $accessToken = null,
        array $tankIds = [],
        string|null $inGarage = null,
    ): ApiResult {
        return Wot::client()->tanks()->achievements(
            $accountId,
            $language,
            $fields,
            $accessToken,
            $tankIds,
            $inGarage,
        );
    }

    /**
     * tanks/achievements; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     * @param list<int> $tankIds
     */
    public static function prepareAchievements(
        int $accountId,
        string|null $language = null,
        array $fields = [],
        #[SensitiveParameter] AccessToken|null $accessToken = null,
        array $tankIds = [],
        string|null $inGarage = null,
    ): PreparedOperation {
        return Wot::client()->tanks()->prepareAchievements(
            $accountId,
            $language,
            $fields,
            $accessToken,
            $tankIds,
            $inGarage,
        );
    }

    /**
     * tanks/mastery; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<int> $percentile
     * @param list<string> $fields
     * @param list<int> $tankIds
     */
    public static function mastery(
        string $distribution,
        array $percentile,
        string|null $language = null,
        array $fields = [],
        array $tankIds = [],
    ): ApiResult {
        return Wot::client()->tanks()->mastery($distribution, $percentile, $language, $fields, $tankIds);
    }

    /**
     * tanks/mastery; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<int> $percentile
     * @param list<string> $fields
     * @param list<int> $tankIds
     */
    public static function prepareMastery(
        string $distribution,
        array $percentile,
        string|null $language = null,
        array $fields = [],
        array $tankIds = [],
    ): PreparedOperation {
        return Wot::client()->tanks()->prepareMastery($distribution, $percentile, $language, $fields, $tankIds);
    }

}
