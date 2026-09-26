<?php

declare(strict_types=1);

namespace edrard\WotClient\Services;

use edrard\WgAuth\AccessToken;
use edrard\WotClient\ApiResult;
use edrard\WotClient\Record;
use Generator;
use SensitiveParameter;

/** Generated from resources/endpoints.json; regenerate with tools/generate-endpoints.py. */
final readonly class ClanRatings extends Service
{
    /**
     * clanratings/types; see the official reference linked in docs/ENDPOINTS.md.
     */
    public function types(): ApiResult
    {
        return $this->client->request(
            'clanratings/types',
            [
            ],
            null,
        );
    }

    /**
     * clanratings/dates; see the official reference linked in docs/ENDPOINTS.md.
     */
    public function dates(int|null $limit = null): ApiResult
    {
        return $this->client->request(
            'clanratings/dates',
            [
                'limit' => $limit,
            ],
            null,
        );
    }

    /**
     * clanratings/clans; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<int> $clanIds
     * @param list<string> $fields
     */
    public function clans(
        array $clanIds,
        string|null $language = null,
        array $fields = [],
        int|string|null $date = null,
    ): ApiResult {
        return $this->client->request(
            'clanratings/clans',
            [
                'clan_id' => $clanIds,
                'language' => $language,
                'fields' => $fields,
                'date' => $date,
            ],
            null,
        );
    }

    /**
     * clanratings/neighbors; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     */
    public function neighbors(
        string $rankField,
        int $clanId,
        string|null $language = null,
        array $fields = [],
        int|string|null $date = null,
        int|null $limit = null,
    ): ApiResult {
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
     * clanratings/top; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     */
    public function top(
        string $rankField,
        string|null $language = null,
        array $fields = [],
        int|string|null $date = null,
        int|null $pageNo = null,
        int|null $limit = null,
    ): ApiResult {
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
     * clanratings/top; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     * @return Generator<array-key, Record|null>
     */
    public function iterateTop(
        string $rankField,
        string|null $language = null,
        array $fields = [],
        int|string|null $date = null,
        int|null $limit = null,
        int $startPage = 1,
        int $maxPages = 1000,
    ): Generator {
        return $this->client->iterate(
            'clanratings/top',
            [
                'rank_field' => $rankField,
                'language' => $language,
                'fields' => $fields,
                'date' => $date,
                'limit' => $limit,
            ],
            null,
            $startPage,
            $maxPages,
        );
    }

    /**
     * clanratings/top; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     */
    public function allTop(
        string $rankField,
        string|null $language = null,
        array $fields = [],
        int|string|null $date = null,
        int|null $limit = null,
        int $startPage = 1,
        int $maxPages = 1000,
    ): ApiResult {
        return $this->client->all(
            'clanratings/top',
            [
                'rank_field' => $rankField,
                'language' => $language,
                'fields' => $fields,
                'date' => $date,
                'limit' => $limit,
            ],
            null,
            $startPage,
            $maxPages,
        );
    }

}
