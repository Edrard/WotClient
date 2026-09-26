<?php

declare(strict_types=1);

namespace edrard\WotClient\Services;

use edrard\WgAuth\AccessToken;
use edrard\WotClient\ApiResult;
use edrard\WotClient\Record;
use Generator;
use SensitiveParameter;

/** Generated from resources/endpoints.json; regenerate with tools/generate-endpoints.py. */
final readonly class Stronghold extends Service
{
    /**
     * stronghold/claninfo; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<int> $clanIds
     * @param list<string> $fields
     */
    public function clanInfo(array $clanIds, array $fields = [], string|null $language = null): ApiResult
    {
        return $this->client->request(
            'stronghold/claninfo',
            [
                'clan_id' => $clanIds,
                'fields' => $fields,
                'language' => $language,
            ],
            null,
        );
    }

    /**
     * stronghold/clanreserves; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     */
    public function clanReserves(
        #[SensitiveParameter] AccessToken $accessToken,
        array $fields = [],
        string|null $language = null,
    ): ApiResult {
        return $this->client->request(
            'stronghold/clanreserves',
            [
                'fields' => $fields,
                'language' => $language,
            ],
            $accessToken,
        );
    }

    /**
     * stronghold/activateclanreserve; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     * Activates a real clan reserve. No automatic retries; a timeout has an unknown outcome.
     */
    public function activateClanReserve(
        #[SensitiveParameter] AccessToken $accessToken,
        string $reserveType,
        int $reserveLevel,
        array $fields = [],
        string|null $language = null,
    ): ApiResult {
        return $this->client->request(
            'stronghold/activateclanreserve',
            [
                'reserve_type' => $reserveType,
                'reserve_level' => $reserveLevel,
                'fields' => $fields,
                'language' => $language,
            ],
            $accessToken,
        );
    }

}
