<?php

declare(strict_types=1);

namespace edrard\WotClient\Services;

use edrard\WgAuth\AccessToken;
use edrard\WotClient\ApiResult;
use edrard\WotClient\Record;
use Generator;
use SensitiveParameter;

/** Generated from resources/endpoints.json; regenerate with tools/generate-endpoints.py. */
final readonly class Encyclopedia extends Service
{
    /**
     * encyclopedia/tanks; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     * @deprecated WG marks this endpoint deprecated; requires explicit client opt-in.
     */
    public function tanks(string|null $language = null, array $fields = []): ApiResult
    {
        return $this->client->request(
            'encyclopedia/tanks',
            [
                'language' => $language,
                'fields' => $fields,
            ],
            null,
        );
    }

    /**
     * encyclopedia/tankinfo; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<int> $tankIds
     * @param list<string> $fields
     * @deprecated WG marks this endpoint deprecated; requires explicit client opt-in.
     */
    public function tankInfo(array $tankIds, string|null $language = null, array $fields = []): ApiResult
    {
        return $this->client->request(
            'encyclopedia/tankinfo',
            [
                'tank_id' => $tankIds,
                'language' => $language,
                'fields' => $fields,
            ],
            null,
        );
    }

    /**
     * encyclopedia/vehicles; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     * @param list<int> $tankIds
     * @param list<string> $nation
     * @param list<string> $type
     * @param list<int> $tier
     */
    public function vehicles(
        array $fields = [],
        string|null $language = null,
        int|null $pageNo = null,
        int|null $limit = null,
        array $tankIds = [],
        array $nation = [],
        array $type = [],
        array $tier = [],
    ): ApiResult {
        return $this->client->request(
            'encyclopedia/vehicles',
            [
                'fields' => $fields,
                'language' => $language,
                'page_no' => $pageNo,
                'limit' => $limit,
                'tank_id' => $tankIds,
                'nation' => $nation,
                'type' => $type,
                'tier' => $tier,
            ],
            null,
        );
    }

    /**
     * encyclopedia/vehicles; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     * @param list<int> $tankIds
     * @param list<string> $nation
     * @param list<string> $type
     * @param list<int> $tier
     * @return Generator<array-key, Record|null>
     */
    public function iterateVehicles(
        array $fields = [],
        string|null $language = null,
        int|null $limit = null,
        array $tankIds = [],
        array $nation = [],
        array $type = [],
        array $tier = [],
        int $startPage = 1,
        int $maxPages = 1000,
    ): Generator {
        return $this->client->iterate(
            'encyclopedia/vehicles',
            [
                'fields' => $fields,
                'language' => $language,
                'limit' => $limit,
                'tank_id' => $tankIds,
                'nation' => $nation,
                'type' => $type,
                'tier' => $tier,
            ],
            null,
            $startPage,
            $maxPages,
        );
    }

    /**
     * encyclopedia/vehicles; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     * @param list<int> $tankIds
     * @param list<string> $nation
     * @param list<string> $type
     * @param list<int> $tier
     */
    public function allVehicles(
        array $fields = [],
        string|null $language = null,
        int|null $limit = null,
        array $tankIds = [],
        array $nation = [],
        array $type = [],
        array $tier = [],
        int $startPage = 1,
        int $maxPages = 1000,
    ): ApiResult {
        return $this->client->all(
            'encyclopedia/vehicles',
            [
                'fields' => $fields,
                'language' => $language,
                'limit' => $limit,
                'tank_id' => $tankIds,
                'nation' => $nation,
                'type' => $type,
                'tier' => $tier,
            ],
            null,
            $startPage,
            $maxPages,
        );
    }

    /**
     * encyclopedia/vehicleprofile; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     */
    public function vehicleProfile(
        int $tankId,
        array $fields = [],
        string|null $language = null,
        int|null $engineId = null,
        int|null $gunId = null,
        int|null $suspensionId = null,
        int|null $turretId = null,
        int|null $radioId = null,
        string|null $profileId = null,
    ): ApiResult {
        return $this->client->request(
            'encyclopedia/vehicleprofile',
            [
                'tank_id' => $tankId,
                'fields' => $fields,
                'language' => $language,
                'engine_id' => $engineId,
                'gun_id' => $gunId,
                'suspension_id' => $suspensionId,
                'turret_id' => $turretId,
                'radio_id' => $radioId,
                'profile_id' => $profileId,
            ],
            null,
        );
    }

    /**
     * encyclopedia/tankengines; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     * @param list<int> $moduleIds
     * @param list<string> $nation
     * @deprecated WG marks this endpoint deprecated; requires explicit client opt-in.
     */
    public function tankEngines(
        string|null $language = null,
        array $fields = [],
        array $moduleIds = [],
        array $nation = [],
    ): ApiResult {
        return $this->client->request(
            'encyclopedia/tankengines',
            [
                'language' => $language,
                'fields' => $fields,
                'module_id' => $moduleIds,
                'nation' => $nation,
            ],
            null,
        );
    }

    /**
     * encyclopedia/tankturrets; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     * @param list<int> $moduleIds
     * @param list<string> $nation
     * @deprecated WG marks this endpoint deprecated; requires explicit client opt-in.
     */
    public function tankTurrets(
        string|null $language = null,
        array $fields = [],
        array $moduleIds = [],
        array $nation = [],
    ): ApiResult {
        return $this->client->request(
            'encyclopedia/tankturrets',
            [
                'language' => $language,
                'fields' => $fields,
                'module_id' => $moduleIds,
                'nation' => $nation,
            ],
            null,
        );
    }

    /**
     * encyclopedia/tankradios; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     * @param list<int> $moduleIds
     * @param list<string> $nation
     * @deprecated WG marks this endpoint deprecated; requires explicit client opt-in.
     */
    public function tankRadios(
        string|null $language = null,
        array $fields = [],
        array $moduleIds = [],
        array $nation = [],
    ): ApiResult {
        return $this->client->request(
            'encyclopedia/tankradios',
            [
                'language' => $language,
                'fields' => $fields,
                'module_id' => $moduleIds,
                'nation' => $nation,
            ],
            null,
        );
    }

    /**
     * encyclopedia/tankchassis; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     * @param list<int> $moduleIds
     * @param list<string> $nation
     * @deprecated WG marks this endpoint deprecated; requires explicit client opt-in.
     */
    public function tankChassis(
        string|null $language = null,
        array $fields = [],
        array $moduleIds = [],
        array $nation = [],
    ): ApiResult {
        return $this->client->request(
            'encyclopedia/tankchassis',
            [
                'language' => $language,
                'fields' => $fields,
                'module_id' => $moduleIds,
                'nation' => $nation,
            ],
            null,
        );
    }

    /**
     * encyclopedia/tankguns; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     * @param list<int> $moduleIds
     * @param list<string> $nation
     * @deprecated WG marks this endpoint deprecated; requires explicit client opt-in.
     */
    public function tankGuns(
        string|null $language = null,
        array $fields = [],
        array $moduleIds = [],
        array $nation = [],
        int|null $turretId = null,
        int|null $tankId = null,
    ): ApiResult {
        return $this->client->request(
            'encyclopedia/tankguns',
            [
                'language' => $language,
                'fields' => $fields,
                'module_id' => $moduleIds,
                'nation' => $nation,
                'turret_id' => $turretId,
                'tank_id' => $tankId,
            ],
            null,
        );
    }

    /**
     * encyclopedia/achievements; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     */
    public function achievements(array $fields = [], string|null $language = null): ApiResult
    {
        return $this->client->request(
            'encyclopedia/achievements',
            [
                'fields' => $fields,
                'language' => $language,
            ],
            null,
        );
    }

    /**
     * encyclopedia/info; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     */
    public function info(array $fields = [], string|null $language = null): ApiResult
    {
        return $this->client->request(
            'encyclopedia/info',
            [
                'fields' => $fields,
                'language' => $language,
            ],
            null,
        );
    }

    /**
     * encyclopedia/arenas; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     */
    public function arenas(array $fields = [], string|null $language = null): ApiResult
    {
        return $this->client->request(
            'encyclopedia/arenas',
            [
                'fields' => $fields,
                'language' => $language,
            ],
            null,
        );
    }

    /**
     * encyclopedia/provisions; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     * @param list<string> $type
     * @param list<int> $provisionIds
     */
    public function provisions(
        array $fields = [],
        string|null $language = null,
        int|null $pageNo = null,
        int|null $limit = null,
        array $type = [],
        array $provisionIds = [],
    ): ApiResult {
        return $this->client->request(
            'encyclopedia/provisions',
            [
                'fields' => $fields,
                'language' => $language,
                'page_no' => $pageNo,
                'limit' => $limit,
                'type' => $type,
                'provision_id' => $provisionIds,
            ],
            null,
        );
    }

    /**
     * encyclopedia/provisions; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     * @param list<string> $type
     * @param list<int> $provisionIds
     * @return Generator<array-key, Record|null>
     */
    public function iterateProvisions(
        array $fields = [],
        string|null $language = null,
        int|null $limit = null,
        array $type = [],
        array $provisionIds = [],
        int $startPage = 1,
        int $maxPages = 1000,
    ): Generator {
        return $this->client->iterate(
            'encyclopedia/provisions',
            [
                'fields' => $fields,
                'language' => $language,
                'limit' => $limit,
                'type' => $type,
                'provision_id' => $provisionIds,
            ],
            null,
            $startPage,
            $maxPages,
        );
    }

    /**
     * encyclopedia/provisions; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     * @param list<string> $type
     * @param list<int> $provisionIds
     */
    public function allProvisions(
        array $fields = [],
        string|null $language = null,
        int|null $limit = null,
        array $type = [],
        array $provisionIds = [],
        int $startPage = 1,
        int $maxPages = 1000,
    ): ApiResult {
        return $this->client->all(
            'encyclopedia/provisions',
            [
                'fields' => $fields,
                'language' => $language,
                'limit' => $limit,
                'type' => $type,
                'provision_id' => $provisionIds,
            ],
            null,
            $startPage,
            $maxPages,
        );
    }

    /**
     * encyclopedia/personalmissions; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     * @param list<int> $campaignIds
     * @param list<int> $operationIds
     * @param list<int> $setIds
     * @param list<string> $tag
     */
    public function personalMissions(
        array $fields = [],
        string|null $language = null,
        array $campaignIds = [],
        array $operationIds = [],
        array $setIds = [],
        array $tag = [],
    ): ApiResult {
        return $this->client->request(
            'encyclopedia/personalmissions',
            [
                'fields' => $fields,
                'language' => $language,
                'campaign_id' => $campaignIds,
                'operation_id' => $operationIds,
                'set_id' => $setIds,
                'tag' => $tag,
            ],
            null,
        );
    }

    /**
     * encyclopedia/boosters; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     */
    public function boosters(array $fields = [], string|null $language = null): ApiResult
    {
        return $this->client->request(
            'encyclopedia/boosters',
            [
                'fields' => $fields,
                'language' => $language,
            ],
            null,
        );
    }

    /**
     * encyclopedia/vehicleprofiles; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     */
    public function vehicleProfiles(
        int $tankId,
        array $fields = [],
        string|null $language = null,
        string|null $orderBy = null,
    ): ApiResult {
        return $this->client->request(
            'encyclopedia/vehicleprofiles',
            [
                'tank_id' => $tankId,
                'fields' => $fields,
                'language' => $language,
                'order_by' => $orderBy,
            ],
            null,
        );
    }

    /**
     * encyclopedia/modules; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     * @param list<string> $extra
     * @param list<int> $moduleIds
     * @param list<string> $type
     * @param list<string> $nation
     */
    public function modules(
        array $fields = [],
        array $extra = [],
        string|null $language = null,
        int|null $pageNo = null,
        int|null $limit = null,
        array $moduleIds = [],
        array $type = [],
        array $nation = [],
    ): ApiResult {
        return $this->client->request(
            'encyclopedia/modules',
            [
                'fields' => $fields,
                'extra' => $extra,
                'language' => $language,
                'page_no' => $pageNo,
                'limit' => $limit,
                'module_id' => $moduleIds,
                'type' => $type,
                'nation' => $nation,
            ],
            null,
        );
    }

    /**
     * encyclopedia/modules; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     * @param list<string> $extra
     * @param list<int> $moduleIds
     * @param list<string> $type
     * @param list<string> $nation
     * @return Generator<array-key, Record|null>
     */
    public function iterateModules(
        array $fields = [],
        array $extra = [],
        string|null $language = null,
        int|null $limit = null,
        array $moduleIds = [],
        array $type = [],
        array $nation = [],
        int $startPage = 1,
        int $maxPages = 1000,
    ): Generator {
        return $this->client->iterate(
            'encyclopedia/modules',
            [
                'fields' => $fields,
                'extra' => $extra,
                'language' => $language,
                'limit' => $limit,
                'module_id' => $moduleIds,
                'type' => $type,
                'nation' => $nation,
            ],
            null,
            $startPage,
            $maxPages,
        );
    }

    /**
     * encyclopedia/modules; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     * @param list<string> $extra
     * @param list<int> $moduleIds
     * @param list<string> $type
     * @param list<string> $nation
     */
    public function allModules(
        array $fields = [],
        array $extra = [],
        string|null $language = null,
        int|null $limit = null,
        array $moduleIds = [],
        array $type = [],
        array $nation = [],
        int $startPage = 1,
        int $maxPages = 1000,
    ): ApiResult {
        return $this->client->all(
            'encyclopedia/modules',
            [
                'fields' => $fields,
                'extra' => $extra,
                'language' => $language,
                'limit' => $limit,
                'module_id' => $moduleIds,
                'type' => $type,
                'nation' => $nation,
            ],
            null,
            $startPage,
            $maxPages,
        );
    }

    /**
     * encyclopedia/badges; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     */
    public function badges(array $fields = [], string|null $language = null): ApiResult
    {
        return $this->client->request(
            'encyclopedia/badges',
            [
                'fields' => $fields,
                'language' => $language,
            ],
            null,
        );
    }

    /**
     * encyclopedia/crewroles; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     * @param list<string> $role
     */
    public function crewRoles(array $fields = [], string|null $language = null, array $role = []): ApiResult
    {
        return $this->client->request(
            'encyclopedia/crewroles',
            [
                'fields' => $fields,
                'language' => $language,
                'role' => $role,
            ],
            null,
        );
    }

    /**
     * encyclopedia/crewskills; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     * @param list<string> $skill
     */
    public function crewSkills(
        array $fields = [],
        string|null $language = null,
        array $skill = [],
        string|null $role = null,
    ): ApiResult {
        return $this->client->request(
            'encyclopedia/crewskills',
            [
                'fields' => $fields,
                'language' => $language,
                'skill' => $skill,
                'role' => $role,
            ],
            null,
        );
    }

}
