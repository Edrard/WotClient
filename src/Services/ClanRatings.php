<?php

declare(strict_types=1);

namespace edrard\WotClient\Services;

use edrard\WotClient\PreparedOperation;
use edrard\WgGetter\FetchResult;
use SensitiveParameter;

/** Generated from resources/endpoints.json by tools/generate-client.mjs. */
final readonly class ClanRatings extends Service
{
    /**
     * clanratings/types. Return one raw result per URL.
     * @return list<FetchResult>
     */
    public function types(
    ): array {
        return $this->client->request(
            'clanratings/types',
            [
            ],
            null,
        );
    }

    /**
     * clanratings/types. Prepare without HTTP I/O.
     */
    public function prepareTypes(
    ): PreparedOperation {
        return $this->client->prepare(
            'clanratings/types',
            [
            ],
            null,
        );
    }

    /**
     * clanratings/dates. Return one raw result per URL.
     * @return list<FetchResult>
     */
    public function dates(
        int|null $limit = null,
    ): array {
        return $this->client->request(
            'clanratings/dates',
            [
                'limit' => $limit,
            ],
            null,
        );
    }

    /**
     * clanratings/dates. Prepare without HTTP I/O.
     */
    public function prepareDates(
        int|null $limit = null,
    ): PreparedOperation {
        return $this->client->prepare(
            'clanratings/dates',
            [
                'limit' => $limit,
            ],
            null,
        );
    }

    /**
     * clanratings/clans. Return one raw result per URL.
     * @param list<int> $clanIds
     * @param list<string> $fields
     * @return list<FetchResult>
     */
    public function clans(
        array $clanIds,
        int $batchSize,
        string|null $language = null,
        array $fields = [],
        int|string|null $date = null,
    ): array {
        return $this->client->request(
            'clanratings/clans',
            [
                'clan_id' => $clanIds,
                'language' => $language,
                'fields' => $fields,
                'date' => $date,
            ],
            $batchSize,
        );
    }

    /**
     * clanratings/clans. Prepare without HTTP I/O.
     * @param list<int> $clanIds
     * @param list<string> $fields
     */
    public function prepareClans(
        array $clanIds,
        int $batchSize,
        string|null $language = null,
        array $fields = [],
        int|string|null $date = null,
    ): PreparedOperation {
        return $this->client->prepare(
            'clanratings/clans',
            [
                'clan_id' => $clanIds,
                'language' => $language,
                'fields' => $fields,
                'date' => $date,
            ],
            $batchSize,
        );
    }

    /**
     * clanratings/neighbors. Return one raw result per URL.
     * @param list<string> $fields
     * @return list<FetchResult>
     */
    public function neighbors(
        string $rankField,
        int $clanId,
        string|null $language = null,
        array $fields = [],
        int|string|null $date = null,
        int|null $limit = null,
    ): array {
        return $this->client->request(
            'clanratings/neighbors',
            [
                'rank_field' => $rankField,
                'clan_id' => $clanId,
                'language' => $language,
                'fields' => $fields,
                'date' => $date,
                'limit' => $limit,
            ],
            null,
        );
    }

    /**
     * clanratings/neighbors. Prepare without HTTP I/O.
     * @param list<string> $fields
     */
    public function prepareNeighbors(
        string $rankField,
        int $clanId,
        string|null $language = null,
        array $fields = [],
        int|string|null $date = null,
        int|null $limit = null,
    ): PreparedOperation {
        return $this->client->prepare(
            'clanratings/neighbors',
            [
                'rank_field' => $rankField,
                'clan_id' => $clanId,
                'language' => $language,
                'fields' => $fields,
                'date' => $date,
                'limit' => $limit,
            ],
            null,
        );
    }

    /**
     * clanratings/top. Return one raw result per URL.
     * @param list<string> $fields
     * @return list<FetchResult>
     */
    public function top(
        string $rankField,
        string|null $language = null,
        array $fields = [],
        int|string|null $date = null,
        int|null $pageNo = null,
        int|null $limit = null,
    ): array {
        return $this->client->request(
            'clanratings/top',
            [
                'rank_field' => $rankField,
                'language' => $language,
                'fields' => $fields,
                'date' => $date,
                'page_no' => $pageNo,
                'limit' => $limit,
            ],
            null,
        );
    }

    /**
     * clanratings/top. Prepare without HTTP I/O.
     * @param list<string> $fields
     */
    public function prepareTop(
        string $rankField,
        string|null $language = null,
        array $fields = [],
        int|string|null $date = null,
        int|null $pageNo = null,
        int|null $limit = null,
    ): PreparedOperation {
        return $this->client->prepare(
            'clanratings/top',
            [
                'rank_field' => $rankField,
                'language' => $language,
                'fields' => $fields,
                'date' => $date,
                'page_no' => $pageNo,
                'limit' => $limit,
            ],
            null,
        );
    }

}
