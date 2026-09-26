<?php

declare(strict_types=1);

namespace edrard\WotClient\Services;

use edrard\WgAuth\AccessToken;
use edrard\WotClient\ApiResult;
use edrard\WotClient\Record;
use Generator;
use SensitiveParameter;

/** Generated from resources/endpoints.json; regenerate with tools/generate-endpoints.py. */
final readonly class Tanks extends Service
{
    /**
     * tanks/stats; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     * @param list<string> $extra
     * @param list<int> $tankIds
     */
    public function stats(
        int $accountId,
        string|null $language = null,
        array $fields = [],
        #[SensitiveParameter] AccessToken|null $accessToken = null,
        array $extra = [],
        array $tankIds = [],
        string|null $inGarage = null,
    ): ApiResult {
        return $this->client->request(
            'tanks/stats',
            [
                'account_id' => $accountId,
                'language' => $language,
                'fields' => $fields,
                'extra' => $extra,
                'tank_id' => $tankIds,
                'in_garage' => $inGarage,
            ],
            $accessToken,
        );
    }

    /**
     * tanks/achievements; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     * @param list<int> $tankIds
     */
    public function achievements(
        int $accountId,
        string|null $language = null,
        array $fields = [],
        #[SensitiveParameter] AccessToken|null $accessToken = null,
        array $tankIds = [],
        string|null $inGarage = null,
    ): ApiResult {
        return $this->client->request(
            'tanks/achievements',
            [
                'account_id' => $accountId,
                'language' => $language,
                'fields' => $fields,
                'tank_id' => $tankIds,
                'in_garage' => $inGarage,
            ],
            $accessToken,
        );
    }

    /**
     * tanks/mastery; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<int> $percentile
     * @param list<string> $fields
     * @param list<int> $tankIds
     */
    public function mastery(
        string $distribution,
        array $percentile,
        string|null $language = null,
        array $fields = [],
        array $tankIds = [],
    ): ApiResult {
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

}
