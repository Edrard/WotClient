<?php

declare(strict_types=1);

namespace edrard\WotClient\Services;

use edrard\WotClient\PreparedOperation;
use edrard\WgGetter\FetchResult;
use SensitiveParameter;

/** Generated from resources/endpoints.json by tools/generate-client.mjs. */
final readonly class Tanks extends Service
{
    /**
     * tanks/stats. Return one raw result per URL.
     * @param list<string> $fields
     * @param list<string> $extra
     * @param list<int> $tankIds
     * @return list<FetchResult>
     */
    public function stats(
        int $accountId,
        string|null $language = null,
        array $fields = [],
        #[SensitiveParameter] string|null $accessToken = null,
        array $extra = [],
        array $tankIds = [],
        string|null $inGarage = null,
    ): array {
        return $this->client->request(
            'tanks/stats',
            [
                'account_id' => $accountId,
                'language' => $language,
                'fields' => $fields,
                'access_token' => $accessToken,
                'extra' => $extra,
                'tank_id' => $tankIds,
                'in_garage' => $inGarage,
            ],
            null,
        );
    }

    /**
     * tanks/stats. Prepare without HTTP I/O.
     * @param list<string> $fields
     * @param list<string> $extra
     * @param list<int> $tankIds
     */
    public function prepareStats(
        int $accountId,
        string|null $language = null,
        array $fields = [],
        #[SensitiveParameter] string|null $accessToken = null,
        array $extra = [],
        array $tankIds = [],
        string|null $inGarage = null,
    ): PreparedOperation {
        return $this->client->prepare(
            'tanks/stats',
            [
                'account_id' => $accountId,
                'language' => $language,
                'fields' => $fields,
                'access_token' => $accessToken,
                'extra' => $extra,
                'tank_id' => $tankIds,
                'in_garage' => $inGarage,
            ],
            null,
        );
    }

    /**
     * tanks/achievements. Return one raw result per URL.
     * @param list<string> $fields
     * @param list<int> $tankIds
     * @return list<FetchResult>
     */
    public function achievements(
        int $accountId,
        string|null $language = null,
        array $fields = [],
        #[SensitiveParameter] string|null $accessToken = null,
        array $tankIds = [],
        string|null $inGarage = null,
    ): array {
        return $this->client->request(
            'tanks/achievements',
            [
                'account_id' => $accountId,
                'language' => $language,
                'fields' => $fields,
                'access_token' => $accessToken,
                'tank_id' => $tankIds,
                'in_garage' => $inGarage,
            ],
            null,
        );
    }

    /**
     * tanks/achievements. Prepare without HTTP I/O.
     * @param list<string> $fields
     * @param list<int> $tankIds
     */
    public function prepareAchievements(
        int $accountId,
        string|null $language = null,
        array $fields = [],
        #[SensitiveParameter] string|null $accessToken = null,
        array $tankIds = [],
        string|null $inGarage = null,
    ): PreparedOperation {
        return $this->client->prepare(
            'tanks/achievements',
            [
                'account_id' => $accountId,
                'language' => $language,
                'fields' => $fields,
                'access_token' => $accessToken,
                'tank_id' => $tankIds,
                'in_garage' => $inGarage,
            ],
            null,
        );
    }

    /**
     * tanks/mastery. Return one raw result per URL.
     * @param list<int> $percentile
     * @param list<string> $fields
     * @param list<int> $tankIds
     * @return list<FetchResult>
     */
    public function mastery(
        string $distribution,
        array $percentile,
        string|null $language = null,
        array $fields = [],
        array $tankIds = [],
    ): array {
        return $this->client->request(
            'tanks/mastery',
            [
                'distribution' => $distribution,
                'percentile' => $percentile,
                'language' => $language,
                'fields' => $fields,
                'tank_id' => $tankIds,
            ],
            null,
        );
    }

    /**
     * tanks/mastery. Prepare without HTTP I/O.
     * @param list<int> $percentile
     * @param list<string> $fields
     * @param list<int> $tankIds
     */
    public function prepareMastery(
        string $distribution,
        array $percentile,
        string|null $language = null,
        array $fields = [],
        array $tankIds = [],
    ): PreparedOperation {
        return $this->client->prepare(
            'tanks/mastery',
            [
                'distribution' => $distribution,
                'percentile' => $percentile,
                'language' => $language,
                'fields' => $fields,
                'tank_id' => $tankIds,
            ],
            null,
        );
    }

}
