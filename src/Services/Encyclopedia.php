<?php

declare(strict_types=1);

namespace edrard\WotClient\Services;

use edrard\WotClient\PreparedOperation;
use edrard\WgGetter\FetchResult;
use SensitiveParameter;

/** Generated from resources/endpoints.json by tools/generate-client.mjs. */
final readonly class Encyclopedia extends Service
{
    /**
     * encyclopedia/tanks. Return one raw result per URL.
     * @deprecated Marked deprecated in the WG catalog; requests remain available.
     * @param list<string> $fields
     * @return list<FetchResult>
     */
    public function tanks(
        string|null $language = null,
        array $fields = [],
    ): array {
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
     * encyclopedia/tanks. Prepare without HTTP I/O.
     * @deprecated Marked deprecated in the WG catalog; requests remain available.
     * @param list<string> $fields
     */
    public function prepareTanks(
        string|null $language = null,
        array $fields = [],
    ): PreparedOperation {
        return $this->client->prepare(
            'encyclopedia/tanks',
            [
                'language' => $language,
                'fields' => $fields,
            ],
            null,
        );
    }

    /**
     * encyclopedia/tankinfo. Return one raw result per URL.
     * @deprecated Marked deprecated in the WG catalog; requests remain available.
     * @param list<int> $tankIds
     * @param list<string> $fields
     * @return list<FetchResult>
     */
    public function tankInfo(
        array $tankIds,
        int $batchSize,
        string|null $language = null,
        array $fields = [],
    ): array {
        return $this->client->request(
            'encyclopedia/tankinfo',
            [
                'tank_id' => $tankIds,
                'language' => $language,
                'fields' => $fields,
            ],
            $batchSize,
        );
    }

    /**
     * encyclopedia/tankinfo. Prepare without HTTP I/O.
     * @deprecated Marked deprecated in the WG catalog; requests remain available.
     * @param list<int> $tankIds
     * @param list<string> $fields
     */
    public function prepareTankInfo(
        array $tankIds,
        int $batchSize,
        string|null $language = null,
        array $fields = [],
    ): PreparedOperation {
        return $this->client->prepare(
            'encyclopedia/tankinfo',
            [
                'tank_id' => $tankIds,
                'language' => $language,
                'fields' => $fields,
            ],
            $batchSize,
        );
    }

    /**
     * encyclopedia/vehicles. Return one raw result per URL.
     * @param list<string> $fields
     * @param list<int> $tankIds
     * @param list<string> $nation
     * @param list<string> $type
     * @param list<int> $tier
     * @return list<FetchResult>
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
    ): array {
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
     * encyclopedia/vehicles. Prepare without HTTP I/O.
     * @param list<string> $fields
     * @param list<int> $tankIds
     * @param list<string> $nation
     * @param list<string> $type
     * @param list<int> $tier
     */
    public function prepareVehicles(
        array $fields = [],
        string|null $language = null,
        int|null $pageNo = null,
        int|null $limit = null,
        array $tankIds = [],
        array $nation = [],
        array $type = [],
        array $tier = [],
    ): PreparedOperation {
        return $this->client->prepare(
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
     * encyclopedia/vehicleprofile. Return one raw result per URL.
     * @param list<string> $fields
     * @return list<FetchResult>
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
    ): array {
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
     * encyclopedia/vehicleprofile. Prepare without HTTP I/O.
     * @param list<string> $fields
     */
    public function prepareVehicleProfile(
        int $tankId,
        array $fields = [],
        string|null $language = null,
        int|null $engineId = null,
        int|null $gunId = null,
        int|null $suspensionId = null,
        int|null $turretId = null,
        int|null $radioId = null,
        string|null $profileId = null,
    ): PreparedOperation {
        return $this->client->prepare(
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
     * encyclopedia/tankengines. Return one raw result per URL.
     * @deprecated Marked deprecated in the WG catalog; requests remain available.
     * @param list<string> $fields
     * @param list<int> $moduleIds
     * @param list<string> $nation
     * @return list<FetchResult>
     */
    public function tankEngines(
        string|null $language = null,
        array $fields = [],
        array $moduleIds = [],
        array $nation = [],
    ): array {
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
     * encyclopedia/tankengines. Prepare without HTTP I/O.
     * @deprecated Marked deprecated in the WG catalog; requests remain available.
     * @param list<string> $fields
     * @param list<int> $moduleIds
     * @param list<string> $nation
     */
    public function prepareTankEngines(
        string|null $language = null,
        array $fields = [],
        array $moduleIds = [],
        array $nation = [],
    ): PreparedOperation {
        return $this->client->prepare(
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
     * encyclopedia/tankturrets. Return one raw result per URL.
     * @deprecated Marked deprecated in the WG catalog; requests remain available.
     * @param list<string> $fields
     * @param list<int> $moduleIds
     * @param list<string> $nation
     * @return list<FetchResult>
     */
    public function tankTurrets(
        string|null $language = null,
        array $fields = [],
        array $moduleIds = [],
        array $nation = [],
    ): array {
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
     * encyclopedia/tankturrets. Prepare without HTTP I/O.
     * @deprecated Marked deprecated in the WG catalog; requests remain available.
     * @param list<string> $fields
     * @param list<int> $moduleIds
     * @param list<string> $nation
     */
    public function prepareTankTurrets(
        string|null $language = null,
        array $fields = [],
        array $moduleIds = [],
        array $nation = [],
    ): PreparedOperation {
        return $this->client->prepare(
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
     * encyclopedia/tankradios. Return one raw result per URL.
     * @deprecated Marked deprecated in the WG catalog; requests remain available.
     * @param list<string> $fields
     * @param list<int> $moduleIds
     * @param list<string> $nation
     * @return list<FetchResult>
     */
    public function tankRadios(
        string|null $language = null,
        array $fields = [],
        array $moduleIds = [],
        array $nation = [],
    ): array {
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
     * encyclopedia/tankradios. Prepare without HTTP I/O.
     * @deprecated Marked deprecated in the WG catalog; requests remain available.
     * @param list<string> $fields
     * @param list<int> $moduleIds
     * @param list<string> $nation
     */
    public function prepareTankRadios(
        string|null $language = null,
        array $fields = [],
        array $moduleIds = [],
        array $nation = [],
    ): PreparedOperation {
        return $this->client->prepare(
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
     * encyclopedia/tankchassis. Return one raw result per URL.
     * @deprecated Marked deprecated in the WG catalog; requests remain available.
     * @param list<string> $fields
     * @param list<int> $moduleIds
     * @param list<string> $nation
     * @return list<FetchResult>
     */
    public function tankChassis(
        string|null $language = null,
        array $fields = [],
        array $moduleIds = [],
        array $nation = [],
    ): array {
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
     * encyclopedia/tankchassis. Prepare without HTTP I/O.
     * @deprecated Marked deprecated in the WG catalog; requests remain available.
     * @param list<string> $fields
     * @param list<int> $moduleIds
     * @param list<string> $nation
     */
    public function prepareTankChassis(
        string|null $language = null,
        array $fields = [],
        array $moduleIds = [],
        array $nation = [],
    ): PreparedOperation {
        return $this->client->prepare(
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
     * encyclopedia/tankguns. Return one raw result per URL.
     * @deprecated Marked deprecated in the WG catalog; requests remain available.
     * @param list<string> $fields
     * @param list<int> $moduleIds
     * @param list<string> $nation
     * @return list<FetchResult>
     */
    public function tankGuns(
        string|null $language = null,
        array $fields = [],
        array $moduleIds = [],
        array $nation = [],
        int|null $turretId = null,
        int|null $tankId = null,
    ): array {
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
     * encyclopedia/tankguns. Prepare without HTTP I/O.
     * @deprecated Marked deprecated in the WG catalog; requests remain available.
     * @param list<string> $fields
     * @param list<int> $moduleIds
     * @param list<string> $nation
     */
    public function prepareTankGuns(
        string|null $language = null,
        array $fields = [],
        array $moduleIds = [],
        array $nation = [],
        int|null $turretId = null,
        int|null $tankId = null,
    ): PreparedOperation {
        return $this->client->prepare(
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
     * encyclopedia/achievements. Return one raw result per URL.
     * @param list<string> $fields
     * @return list<FetchResult>
     */
    public function achievements(
        array $fields = [],
        string|null $language = null,
    ): array {
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
     * encyclopedia/achievements. Prepare without HTTP I/O.
     * @param list<string> $fields
     */
    public function prepareAchievements(
        array $fields = [],
        string|null $language = null,
    ): PreparedOperation {
        return $this->client->prepare(
            'encyclopedia/achievements',
            [
                'fields' => $fields,
                'language' => $language,
            ],
            null,
        );
    }

    /**
     * encyclopedia/info. Return one raw result per URL.
     * @param list<string> $fields
     * @return list<FetchResult>
     */
    public function info(
        array $fields = [],
        string|null $language = null,
    ): array {
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
     * encyclopedia/info. Prepare without HTTP I/O.
     * @param list<string> $fields
     */
    public function prepareInfo(
        array $fields = [],
        string|null $language = null,
    ): PreparedOperation {
        return $this->client->prepare(
            'encyclopedia/info',
            [
                'fields' => $fields,
                'language' => $language,
            ],
            null,
        );
    }

    /**
     * encyclopedia/arenas. Return one raw result per URL.
     * @param list<string> $fields
     * @return list<FetchResult>
     */
    public function arenas(
        array $fields = [],
        string|null $language = null,
    ): array {
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
     * encyclopedia/arenas. Prepare without HTTP I/O.
     * @param list<string> $fields
     */
    public function prepareArenas(
        array $fields = [],
        string|null $language = null,
    ): PreparedOperation {
        return $this->client->prepare(
            'encyclopedia/arenas',
            [
                'fields' => $fields,
                'language' => $language,
            ],
            null,
        );
    }

    /**
     * encyclopedia/provisions. Return one raw result per URL.
     * @param list<string> $fields
     * @param list<string> $type
     * @param list<int> $provisionIds
     * @return list<FetchResult>
     */
    public function provisions(
        array $fields = [],
        string|null $language = null,
        int|null $pageNo = null,
        int|null $limit = null,
        array $type = [],
        array $provisionIds = [],
    ): array {
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
     * encyclopedia/provisions. Prepare without HTTP I/O.
     * @param list<string> $fields
     * @param list<string> $type
     * @param list<int> $provisionIds
     */
    public function prepareProvisions(
        array $fields = [],
        string|null $language = null,
        int|null $pageNo = null,
        int|null $limit = null,
        array $type = [],
        array $provisionIds = [],
    ): PreparedOperation {
        return $this->client->prepare(
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
     * encyclopedia/personalmissions. Return one raw result per URL.
     * @param list<string> $fields
     * @param list<int> $campaignIds
     * @param list<int> $operationIds
     * @param list<int> $setIds
     * @param list<string> $tag
     * @return list<FetchResult>
     */
    public function personalMissions(
        array $fields = [],
        string|null $language = null,
        array $campaignIds = [],
        array $operationIds = [],
        array $setIds = [],
        array $tag = [],
    ): array {
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
     * encyclopedia/personalmissions. Prepare without HTTP I/O.
     * @param list<string> $fields
     * @param list<int> $campaignIds
     * @param list<int> $operationIds
     * @param list<int> $setIds
     * @param list<string> $tag
     */
    public function preparePersonalMissions(
        array $fields = [],
        string|null $language = null,
        array $campaignIds = [],
        array $operationIds = [],
        array $setIds = [],
        array $tag = [],
    ): PreparedOperation {
        return $this->client->prepare(
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
     * encyclopedia/boosters. Return one raw result per URL.
     * @param list<string> $fields
     * @return list<FetchResult>
     */
    public function boosters(
        array $fields = [],
        string|null $language = null,
    ): array {
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
     * encyclopedia/boosters. Prepare without HTTP I/O.
     * @param list<string> $fields
     */
    public function prepareBoosters(
        array $fields = [],
        string|null $language = null,
    ): PreparedOperation {
        return $this->client->prepare(
            'encyclopedia/boosters',
            [
                'fields' => $fields,
                'language' => $language,
            ],
            null,
        );
    }

    /**
     * encyclopedia/vehicleprofiles. Return one raw result per URL.
     * @param list<string> $fields
     * @return list<FetchResult>
     */
    public function vehicleProfiles(
        int $tankId,
        array $fields = [],
        string|null $language = null,
        string|null $orderBy = null,
    ): array {
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
     * encyclopedia/vehicleprofiles. Prepare without HTTP I/O.
     * @param list<string> $fields
     */
    public function prepareVehicleProfiles(
        int $tankId,
        array $fields = [],
        string|null $language = null,
        string|null $orderBy = null,
    ): PreparedOperation {
        return $this->client->prepare(
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
     * encyclopedia/modules. Return one raw result per URL.
     * @param list<string> $fields
     * @param list<string> $extra
     * @param list<int> $moduleIds
     * @param list<string> $type
     * @param list<string> $nation
     * @return list<FetchResult>
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
    ): array {
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
     * encyclopedia/modules. Prepare without HTTP I/O.
     * @param list<string> $fields
     * @param list<string> $extra
     * @param list<int> $moduleIds
     * @param list<string> $type
     * @param list<string> $nation
     */
    public function prepareModules(
        array $fields = [],
        array $extra = [],
        string|null $language = null,
        int|null $pageNo = null,
        int|null $limit = null,
        array $moduleIds = [],
        array $type = [],
        array $nation = [],
    ): PreparedOperation {
        return $this->client->prepare(
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
     * encyclopedia/badges. Return one raw result per URL.
     * @param list<string> $fields
     * @return list<FetchResult>
     */
    public function badges(
        array $fields = [],
        string|null $language = null,
    ): array {
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
     * encyclopedia/badges. Prepare without HTTP I/O.
     * @param list<string> $fields
     */
    public function prepareBadges(
        array $fields = [],
        string|null $language = null,
    ): PreparedOperation {
        return $this->client->prepare(
            'encyclopedia/badges',
            [
                'fields' => $fields,
                'language' => $language,
            ],
            null,
        );
    }

    /**
     * encyclopedia/crewroles. Return one raw result per URL.
     * @param list<string> $fields
     * @param list<string> $role
     * @return list<FetchResult>
     */
    public function crewRoles(
        array $fields = [],
        string|null $language = null,
        array $role = [],
    ): array {
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
     * encyclopedia/crewroles. Prepare without HTTP I/O.
     * @param list<string> $fields
     * @param list<string> $role
     */
    public function prepareCrewRoles(
        array $fields = [],
        string|null $language = null,
        array $role = [],
    ): PreparedOperation {
        return $this->client->prepare(
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
     * encyclopedia/crewskills. Return one raw result per URL.
     * @param list<string> $fields
     * @param list<string> $skill
     * @return list<FetchResult>
     */
    public function crewSkills(
        array $fields = [],
        string|null $language = null,
        array $skill = [],
        string|null $role = null,
    ): array {
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

    /**
     * encyclopedia/crewskills. Prepare without HTTP I/O.
     * @param list<string> $fields
     * @param list<string> $skill
     */
    public function prepareCrewSkills(
        array $fields = [],
        string|null $language = null,
        array $skill = [],
        string|null $role = null,
    ): PreparedOperation {
        return $this->client->prepare(
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
