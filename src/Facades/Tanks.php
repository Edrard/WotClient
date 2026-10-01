<?php

declare(strict_types=1);

namespace edrard\WotClient\Facades;

use edrard\WotClient\PreparedOperation;
use edrard\WgGetter\FetchResult;
use SensitiveParameter;

/** Generated from resources/endpoints.json by tools/generate-client.mjs. */
final class Tanks
{
    /**
     * tanks/stats. Return one raw result per URL.
     * @param list<string> $fields
     * @param list<string> $extra
     * @param list<int> $tankIds
     * @return list<FetchResult>
     */
    public static function stats(
        int $accountId,
        string|null $language = null,
        array $fields = [],
        #[SensitiveParameter] string|null $accessToken = null,
        array $extra = [],
        array $tankIds = [],
        string|null $inGarage = null,
    ): array {
        return Wot::client()->tanks()->stats($accountId, $language, $fields, $accessToken, $extra, $tankIds, $inGarage);
    }

    /**
     * tanks/stats. Prepare without HTTP I/O.
     * @param list<string> $fields
     * @param list<string> $extra
     * @param list<int> $tankIds
     */
    public static function prepareStats(
        int $accountId,
        string|null $language = null,
        array $fields = [],
        #[SensitiveParameter] string|null $accessToken = null,
        array $extra = [],
        array $tankIds = [],
        string|null $inGarage = null,
    ): PreparedOperation {
        return Wot::client()->tanks()->prepareStats($accountId, $language, $fields, $accessToken, $extra, $tankIds, $inGarage);
    }

    /**
     * tanks/achievements. Return one raw result per URL.
     * @param list<string> $fields
     * @param list<int> $tankIds
     * @return list<FetchResult>
     */
    public static function achievements(
        int $accountId,
        string|null $language = null,
        array $fields = [],
        #[SensitiveParameter] string|null $accessToken = null,
        array $tankIds = [],
        string|null $inGarage = null,
    ): array {
        return Wot::client()->tanks()->achievements($accountId, $language, $fields, $accessToken, $tankIds, $inGarage);
    }

    /**
     * tanks/achievements. Prepare without HTTP I/O.
     * @param list<string> $fields
     * @param list<int> $tankIds
     */
    public static function prepareAchievements(
        int $accountId,
        string|null $language = null,
        array $fields = [],
        #[SensitiveParameter] string|null $accessToken = null,
        array $tankIds = [],
        string|null $inGarage = null,
    ): PreparedOperation {
        return Wot::client()->tanks()->prepareAchievements($accountId, $language, $fields, $accessToken, $tankIds, $inGarage);
    }

    /**
     * tanks/mastery. Return one raw result per URL.
     * @param list<int> $percentile
     * @param list<string> $fields
     * @param list<int> $tankIds
     * @return list<FetchResult>
     */
    public static function mastery(
        string $distribution,
        array $percentile,
        string|null $language = null,
        array $fields = [],
        array $tankIds = [],
    ): array {
        return Wot::client()->tanks()->mastery($distribution, $percentile, $language, $fields, $tankIds);
    }

    /**
     * tanks/mastery. Prepare without HTTP I/O.
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
