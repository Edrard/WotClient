<?php

declare(strict_types=1);

namespace edrard\WotClient\Facades;

use edrard\WotClient\PreparedOperation;
use edrard\WgGetter\FetchResult;
use SensitiveParameter;

/** Generated from resources/endpoints.json by tools/generate-client.mjs. */
final class Encyclopedia
{
    /**
     * encyclopedia/tanks. Return one raw result per URL.
     * @deprecated Marked deprecated in the WG catalog; requests remain available.
     * @param list<string> $fields
     * @return list<FetchResult>
     */
    public static function tanks(
        string|null $language = null,
        array $fields = [],
    ): array {
        return Wot::client()->encyclopedia()->tanks($language, $fields);
    }

    /**
     * encyclopedia/tanks. Prepare without HTTP I/O.
     * @deprecated Marked deprecated in the WG catalog; requests remain available.
     * @param list<string> $fields
     */
    public static function prepareTanks(
        string|null $language = null,
        array $fields = [],
    ): PreparedOperation {
        return Wot::client()->encyclopedia()->prepareTanks($language, $fields);
    }

    /**
     * encyclopedia/tankinfo. Return one raw result per URL.
     * @deprecated Marked deprecated in the WG catalog; requests remain available.
     * @param list<int> $tankIds
     * @param list<string> $fields
     * @return list<FetchResult>
     */
    public static function tankInfo(
        array $tankIds,
        int $batchSize,
        string|null $language = null,
        array $fields = [],
    ): array {
        return Wot::client()->encyclopedia()->tankInfo($tankIds, $batchSize, $language, $fields);
    }

    /**
     * encyclopedia/tankinfo. Prepare without HTTP I/O.
     * @deprecated Marked deprecated in the WG catalog; requests remain available.
     * @param list<int> $tankIds
     * @param list<string> $fields
     */
    public static function prepareTankInfo(
        array $tankIds,
        int $batchSize,
        string|null $language = null,
        array $fields = [],
    ): PreparedOperation {
        return Wot::client()->encyclopedia()->prepareTankInfo($tankIds, $batchSize, $language, $fields);
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
    public static function vehicles(
        array $fields = [],
        string|null $language = null,
        int|null $pageNo = null,
        int|null $limit = null,
        array $tankIds = [],
        array $nation = [],
        array $type = [],
        array $tier = [],
    ): array {
        return Wot::client()->encyclopedia()->vehicles($fields, $language, $pageNo, $limit, $tankIds, $nation, $type, $tier);
    }

    /**
     * encyclopedia/vehicles. Prepare without HTTP I/O.
     * @param list<string> $fields
     * @param list<int> $tankIds
     * @param list<string> $nation
     * @param list<string> $type
     * @param list<int> $tier
     */
    public static function prepareVehicles(
        array $fields = [],
        string|null $language = null,
        int|null $pageNo = null,
        int|null $limit = null,
        array $tankIds = [],
        array $nation = [],
        array $type = [],
        array $tier = [],
    ): PreparedOperation {
        return Wot::client()->encyclopedia()->prepareVehicles($fields, $language, $pageNo, $limit, $tankIds, $nation, $type, $tier);
    }

    /**
     * encyclopedia/vehicleprofile. Return one raw result per URL.
     * @param list<string> $fields
     * @return list<FetchResult>
     */
    public static function vehicleProfile(
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
        return Wot::client()->encyclopedia()->vehicleProfile($tankId, $fields, $language, $engineId, $gunId, $suspensionId, $turretId, $radioId, $profileId);
    }

    /**
     * encyclopedia/vehicleprofile. Prepare without HTTP I/O.
     * @param list<string> $fields
     */
    public static function prepareVehicleProfile(
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
        return Wot::client()->encyclopedia()->prepareVehicleProfile($tankId, $fields, $language, $engineId, $gunId, $suspensionId, $turretId, $radioId, $profileId);
    }

    /**
     * encyclopedia/tankengines. Return one raw result per URL.
     * @deprecated Marked deprecated in the WG catalog; requests remain available.
     * @param list<string> $fields
     * @param list<int> $moduleIds
     * @param list<string> $nation
     * @return list<FetchResult>
     */
    public static function tankEngines(
        string|null $language = null,
        array $fields = [],
        array $moduleIds = [],
        array $nation = [],
    ): array {
        return Wot::client()->encyclopedia()->tankEngines($language, $fields, $moduleIds, $nation);
    }

    /**
     * encyclopedia/tankengines. Prepare without HTTP I/O.
     * @deprecated Marked deprecated in the WG catalog; requests remain available.
     * @param list<string> $fields
     * @param list<int> $moduleIds
     * @param list<string> $nation
     */
    public static function prepareTankEngines(
        string|null $language = null,
        array $fields = [],
        array $moduleIds = [],
        array $nation = [],
    ): PreparedOperation {
        return Wot::client()->encyclopedia()->prepareTankEngines($language, $fields, $moduleIds, $nation);
    }

    /**
     * encyclopedia/tankturrets. Return one raw result per URL.
     * @deprecated Marked deprecated in the WG catalog; requests remain available.
     * @param list<string> $fields
     * @param list<int> $moduleIds
     * @param list<string> $nation
     * @return list<FetchResult>
     */
    public static function tankTurrets(
        string|null $language = null,
        array $fields = [],
        array $moduleIds = [],
        array $nation = [],
    ): array {
        return Wot::client()->encyclopedia()->tankTurrets($language, $fields, $moduleIds, $nation);
    }

    /**
     * encyclopedia/tankturrets. Prepare without HTTP I/O.
     * @deprecated Marked deprecated in the WG catalog; requests remain available.
     * @param list<string> $fields
     * @param list<int> $moduleIds
     * @param list<string> $nation
     */
    public static function prepareTankTurrets(
        string|null $language = null,
        array $fields = [],
        array $moduleIds = [],
        array $nation = [],
    ): PreparedOperation {
        return Wot::client()->encyclopedia()->prepareTankTurrets($language, $fields, $moduleIds, $nation);
    }

    /**
     * encyclopedia/tankradios. Return one raw result per URL.
     * @deprecated Marked deprecated in the WG catalog; requests remain available.
     * @param list<string> $fields
     * @param list<int> $moduleIds
     * @param list<string> $nation
     * @return list<FetchResult>
     */
    public static function tankRadios(
        string|null $language = null,
        array $fields = [],
        array $moduleIds = [],
        array $nation = [],
    ): array {
        return Wot::client()->encyclopedia()->tankRadios($language, $fields, $moduleIds, $nation);
    }

    /**
     * encyclopedia/tankradios. Prepare without HTTP I/O.
     * @deprecated Marked deprecated in the WG catalog; requests remain available.
     * @param list<string> $fields
     * @param list<int> $moduleIds
     * @param list<string> $nation
     */
    public static function prepareTankRadios(
        string|null $language = null,
        array $fields = [],
        array $moduleIds = [],
        array $nation = [],
    ): PreparedOperation {
        return Wot::client()->encyclopedia()->prepareTankRadios($language, $fields, $moduleIds, $nation);
    }

    /**
     * encyclopedia/tankchassis. Return one raw result per URL.
     * @deprecated Marked deprecated in the WG catalog; requests remain available.
     * @param list<string> $fields
     * @param list<int> $moduleIds
     * @param list<string> $nation
     * @return list<FetchResult>
     */
    public static function tankChassis(
        string|null $language = null,
        array $fields = [],
        array $moduleIds = [],
        array $nation = [],
    ): array {
        return Wot::client()->encyclopedia()->tankChassis($language, $fields, $moduleIds, $nation);
    }

    /**
     * encyclopedia/tankchassis. Prepare without HTTP I/O.
     * @deprecated Marked deprecated in the WG catalog; requests remain available.
     * @param list<string> $fields
     * @param list<int> $moduleIds
     * @param list<string> $nation
     */
    public static function prepareTankChassis(
        string|null $language = null,
        array $fields = [],
        array $moduleIds = [],
        array $nation = [],
    ): PreparedOperation {
        return Wot::client()->encyclopedia()->prepareTankChassis($language, $fields, $moduleIds, $nation);
    }

    /**
     * encyclopedia/tankguns. Return one raw result per URL.
     * @deprecated Marked deprecated in the WG catalog; requests remain available.
     * @param list<string> $fields
     * @param list<int> $moduleIds
     * @param list<string> $nation
     * @return list<FetchResult>
     */
    public static function tankGuns(
        string|null $language = null,
        array $fields = [],
        array $moduleIds = [],
        array $nation = [],
        int|null $turretId = null,
        int|null $tankId = null,
    ): array {
        return Wot::client()->encyclopedia()->tankGuns($language, $fields, $moduleIds, $nation, $turretId, $tankId);
    }

    /**
     * encyclopedia/tankguns. Prepare without HTTP I/O.
     * @deprecated Marked deprecated in the WG catalog; requests remain available.
     * @param list<string> $fields
     * @param list<int> $moduleIds
     * @param list<string> $nation
     */
    public static function prepareTankGuns(
        string|null $language = null,
        array $fields = [],
        array $moduleIds = [],
        array $nation = [],
        int|null $turretId = null,
        int|null $tankId = null,
    ): PreparedOperation {
        return Wot::client()->encyclopedia()->prepareTankGuns($language, $fields, $moduleIds, $nation, $turretId, $tankId);
    }

    /**
     * encyclopedia/achievements. Return one raw result per URL.
     * @param list<string> $fields
     * @return list<FetchResult>
     */
    public static function achievements(
        array $fields = [],
        string|null $language = null,
    ): array {
        return Wot::client()->encyclopedia()->achievements($fields, $language);
    }

    /**
     * encyclopedia/achievements. Prepare without HTTP I/O.
     * @param list<string> $fields
     */
    public static function prepareAchievements(
        array $fields = [],
        string|null $language = null,
    ): PreparedOperation {
        return Wot::client()->encyclopedia()->prepareAchievements($fields, $language);
    }

    /**
     * encyclopedia/info. Return one raw result per URL.
     * @param list<string> $fields
     * @return list<FetchResult>
     */
    public static function info(
        array $fields = [],
        string|null $language = null,
    ): array {
        return Wot::client()->encyclopedia()->info($fields, $language);
    }

    /**
     * encyclopedia/info. Prepare without HTTP I/O.
     * @param list<string> $fields
     */
    public static function prepareInfo(
        array $fields = [],
        string|null $language = null,
    ): PreparedOperation {
        return Wot::client()->encyclopedia()->prepareInfo($fields, $language);
    }

    /**
     * encyclopedia/arenas. Return one raw result per URL.
     * @param list<string> $fields
     * @return list<FetchResult>
     */
    public static function arenas(
        array $fields = [],
        string|null $language = null,
    ): array {
        return Wot::client()->encyclopedia()->arenas($fields, $language);
    }

    /**
     * encyclopedia/arenas. Prepare without HTTP I/O.
     * @param list<string> $fields
     */
    public static function prepareArenas(
        array $fields = [],
        string|null $language = null,
    ): PreparedOperation {
        return Wot::client()->encyclopedia()->prepareArenas($fields, $language);
    }

    /**
     * encyclopedia/provisions. Return one raw result per URL.
     * @param list<string> $fields
     * @param list<string> $type
     * @param list<int> $provisionIds
     * @return list<FetchResult>
     */
    public static function provisions(
        array $fields = [],
        string|null $language = null,
        int|null $pageNo = null,
        int|null $limit = null,
        array $type = [],
        array $provisionIds = [],
    ): array {
        return Wot::client()->encyclopedia()->provisions($fields, $language, $pageNo, $limit, $type, $provisionIds);
    }

    /**
     * encyclopedia/provisions. Prepare without HTTP I/O.
     * @param list<string> $fields
     * @param list<string> $type
     * @param list<int> $provisionIds
     */
    public static function prepareProvisions(
        array $fields = [],
        string|null $language = null,
        int|null $pageNo = null,
        int|null $limit = null,
        array $type = [],
        array $provisionIds = [],
    ): PreparedOperation {
        return Wot::client()->encyclopedia()->prepareProvisions($fields, $language, $pageNo, $limit, $type, $provisionIds);
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
    public static function personalMissions(
        array $fields = [],
        string|null $language = null,
        array $campaignIds = [],
        array $operationIds = [],
        array $setIds = [],
        array $tag = [],
    ): array {
        return Wot::client()->encyclopedia()->personalMissions($fields, $language, $campaignIds, $operationIds, $setIds, $tag);
    }

    /**
     * encyclopedia/personalmissions. Prepare without HTTP I/O.
     * @param list<string> $fields
     * @param list<int> $campaignIds
     * @param list<int> $operationIds
     * @param list<int> $setIds
     * @param list<string> $tag
     */
    public static function preparePersonalMissions(
        array $fields = [],
        string|null $language = null,
        array $campaignIds = [],
        array $operationIds = [],
        array $setIds = [],
        array $tag = [],
    ): PreparedOperation {
        return Wot::client()->encyclopedia()->preparePersonalMissions($fields, $language, $campaignIds, $operationIds, $setIds, $tag);
    }

    /**
     * encyclopedia/boosters. Return one raw result per URL.
     * @param list<string> $fields
     * @return list<FetchResult>
     */
    public static function boosters(
        array $fields = [],
        string|null $language = null,
    ): array {
        return Wot::client()->encyclopedia()->boosters($fields, $language);
    }

    /**
     * encyclopedia/boosters. Prepare without HTTP I/O.
     * @param list<string> $fields
     */
    public static function prepareBoosters(
        array $fields = [],
        string|null $language = null,
    ): PreparedOperation {
        return Wot::client()->encyclopedia()->prepareBoosters($fields, $language);
    }

    /**
     * encyclopedia/vehicleprofiles. Return one raw result per URL.
     * @param list<string> $fields
     * @return list<FetchResult>
     */
    public static function vehicleProfiles(
        int $tankId,
        array $fields = [],
        string|null $language = null,
        string|null $orderBy = null,
    ): array {
        return Wot::client()->encyclopedia()->vehicleProfiles($tankId, $fields, $language, $orderBy);
    }

    /**
     * encyclopedia/vehicleprofiles. Prepare without HTTP I/O.
     * @param list<string> $fields
     */
    public static function prepareVehicleProfiles(
        int $tankId,
        array $fields = [],
        string|null $language = null,
        string|null $orderBy = null,
    ): PreparedOperation {
        return Wot::client()->encyclopedia()->prepareVehicleProfiles($tankId, $fields, $language, $orderBy);
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
    public static function modules(
        array $fields = [],
        array $extra = [],
        string|null $language = null,
        int|null $pageNo = null,
        int|null $limit = null,
        array $moduleIds = [],
        array $type = [],
        array $nation = [],
    ): array {
        return Wot::client()->encyclopedia()->modules($fields, $extra, $language, $pageNo, $limit, $moduleIds, $type, $nation);
    }

    /**
     * encyclopedia/modules. Prepare without HTTP I/O.
     * @param list<string> $fields
     * @param list<string> $extra
     * @param list<int> $moduleIds
     * @param list<string> $type
     * @param list<string> $nation
     */
    public static function prepareModules(
        array $fields = [],
        array $extra = [],
        string|null $language = null,
        int|null $pageNo = null,
        int|null $limit = null,
        array $moduleIds = [],
        array $type = [],
        array $nation = [],
    ): PreparedOperation {
        return Wot::client()->encyclopedia()->prepareModules($fields, $extra, $language, $pageNo, $limit, $moduleIds, $type, $nation);
    }

    /**
     * encyclopedia/badges. Return one raw result per URL.
     * @param list<string> $fields
     * @return list<FetchResult>
     */
    public static function badges(
        array $fields = [],
        string|null $language = null,
    ): array {
        return Wot::client()->encyclopedia()->badges($fields, $language);
    }

    /**
     * encyclopedia/badges. Prepare without HTTP I/O.
     * @param list<string> $fields
     */
    public static function prepareBadges(
        array $fields = [],
        string|null $language = null,
    ): PreparedOperation {
        return Wot::client()->encyclopedia()->prepareBadges($fields, $language);
    }

    /**
     * encyclopedia/crewroles. Return one raw result per URL.
     * @param list<string> $fields
     * @param list<string> $role
     * @return list<FetchResult>
     */
    public static function crewRoles(
        array $fields = [],
        string|null $language = null,
        array $role = [],
    ): array {
        return Wot::client()->encyclopedia()->crewRoles($fields, $language, $role);
    }

    /**
     * encyclopedia/crewroles. Prepare without HTTP I/O.
     * @param list<string> $fields
     * @param list<string> $role
     */
    public static function prepareCrewRoles(
        array $fields = [],
        string|null $language = null,
        array $role = [],
    ): PreparedOperation {
        return Wot::client()->encyclopedia()->prepareCrewRoles($fields, $language, $role);
    }

    /**
     * encyclopedia/crewskills. Return one raw result per URL.
     * @param list<string> $fields
     * @param list<string> $skill
     * @return list<FetchResult>
     */
    public static function crewSkills(
        array $fields = [],
        string|null $language = null,
        array $skill = [],
        string|null $role = null,
    ): array {
        return Wot::client()->encyclopedia()->crewSkills($fields, $language, $skill, $role);
    }

    /**
     * encyclopedia/crewskills. Prepare without HTTP I/O.
     * @param list<string> $fields
     * @param list<string> $skill
     */
    public static function prepareCrewSkills(
        array $fields = [],
        string|null $language = null,
        array $skill = [],
        string|null $role = null,
    ): PreparedOperation {
        return Wot::client()->encyclopedia()->prepareCrewSkills($fields, $language, $skill, $role);
    }

}
