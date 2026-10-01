<?php

declare(strict_types=1);

namespace edrard\WotClient\Services;

use edrard\WotClient\PreparedOperation;
use edrard\WgGetter\FetchResult;
use SensitiveParameter;

/** Generated from resources/endpoints.json by tools/generate-client.mjs. */
final readonly class Stronghold extends Service
{
    /**
     * stronghold/claninfo. Return one raw result per URL.
     * @param list<int> $clanIds
     * @param list<string> $fields
     * @return list<FetchResult>
     */
    public function clanInfo(
        array $clanIds,
        int $batchSize,
        array $fields = [],
        string|null $language = null,
    ): array {
        return $this->client->request(
            'stronghold/claninfo',
            [
                'clan_id' => $clanIds,
                'fields' => $fields,
                'language' => $language,
            ],
            $batchSize,
        );
    }

    /**
     * stronghold/claninfo. Prepare without HTTP I/O.
     * @param list<int> $clanIds
     * @param list<string> $fields
     */
    public function prepareClanInfo(
        array $clanIds,
        int $batchSize,
        array $fields = [],
        string|null $language = null,
    ): PreparedOperation {
        return $this->client->prepare(
            'stronghold/claninfo',
            [
                'clan_id' => $clanIds,
                'fields' => $fields,
                'language' => $language,
            ],
            $batchSize,
        );
    }

    /**
     * stronghold/clanreserves. Return one raw result per URL.
     * @param list<string> $fields
     * @return list<FetchResult>
     */
    public function clanReserves(
        #[SensitiveParameter] string $accessToken,
        array $fields = [],
        string|null $language = null,
    ): array {
        return $this->client->request(
            'stronghold/clanreserves',
            [
                'access_token' => $accessToken,
                'fields' => $fields,
                'language' => $language,
            ],
            null,
        );
    }

    /**
     * stronghold/clanreserves. Prepare without HTTP I/O.
     * @param list<string> $fields
     */
    public function prepareClanReserves(
        #[SensitiveParameter] string $accessToken,
        array $fields = [],
        string|null $language = null,
    ): PreparedOperation {
        return $this->client->prepare(
            'stronghold/clanreserves',
            [
                'access_token' => $accessToken,
                'fields' => $fields,
                'language' => $language,
            ],
            null,
        );
    }

}
