<?php

declare(strict_types=1);

namespace edrard\WotClient\Facades;

use edrard\WgAuth\AccessToken;
use edrard\WotClient\ApiResult;
use edrard\WotClient\PreparedOperation;
use edrard\WotClient\Record;
use Generator;
use SensitiveParameter;

/** Generated from resources/endpoints.json; regenerate with tools/generate-endpoints.py. */
final class Encyclopedia
{
    /**
     * encyclopedia/tanks; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     * @deprecated WG marks this endpoint deprecated; requires explicit client opt-in.
     */
    public static function tanks(string|null $language = null, array $fields = []): ApiResult
    {
        return Wot::client()->encyclopedia()->tanks($language, $fields);
    }

    /**
     * encyclopedia/tanks; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     * @deprecated WG marks this endpoint deprecated; requires explicit client opt-in.
     */
    public static function prepareTanks(string|null $language = null, array $fields = []): PreparedOperation
    {
        return Wot::client()->encyclopedia()->prepareTanks($language, $fields);
    }

    /**
     * encyclopedia/tankinfo; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<int> $tankIds
     * @param list<string> $fields
     * @deprecated WG marks this endpoint deprecated; requires explicit client opt-in.
     */
    public static function tankInfo(array $tankIds, string|null $language = null, array $fields = []): ApiResult
    {
        return Wot::client()->encyclopedia()->tankInfo($tankIds, $language, $fields);
    }

    /**
     * encyclopedia/tankinfo; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<int> $tankIds
     * @param list<string> $fields
     * @deprecated WG marks this endpoint deprecated; requires explicit client opt-in.
     */
    public static function prepareTankInfo(array $tankIds, string|null $language = null, array $fields = []): PreparedOperation
    {
        return Wot::client()->encyclopedia()->prepareTankInfo($tankIds, $language, $fields);
    }

    /**
     * encyclopedia/vehicles; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     * @param list<int> $tankIds
     * @param list<string> $nation
     * @param list<string> $type
     * @param list<int> $tier
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
    ): ApiResult {
        return Wot::client()->encyclopedia()->vehicles(
            $fields,
            $language,
            $pageNo,
            $limit,
            $tankIds,
            $nation,
            $type,
            $tier,
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
        return Wot::client()->encyclopedia()->prepareVehicles(
            $fields,
            $language,
            $pageNo,
            $limit,
            $tankIds,
            $nation,
            $type,
            $tier,
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
    public static function iterateVehicles(
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
        return Wot::client()->encyclopedia()->iterateVehicles(
            $fields,
            $language,
            $limit,
            $tankIds,
            $nation,
            $type,
            $tier,
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
    public static function allVehicles(
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
        return Wot::client()->encyclopedia()->allVehicles(
            $fields,
            $language,
            $limit,
            $tankIds,
            $nation,
            $type,
            $tier,
            $startPage,
            $maxPages,
        );
    }

    /**
     * encyclopedia/vehicleprofile; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
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
    ): ApiResult {
        return Wot::client()->encyclopedia()->vehicleProfile(
            $tankId,
            $fields,
            $language,
            $engineId,
            $gunId,
            $suspensionId,
            $turretId,
            $radioId,
            $profileId,
        );
    }

    /**
     * encyclopedia/vehicleprofile; see the official reference linked in docs/ENDPOINTS.md.
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
        return Wot::client()->encyclopedia()->prepareVehicleProfile(
            $tankId,
            $fields,
            $language,
            $engineId,
            $gunId,
            $suspensionId,
            $turretId,
            $radioId,
            $profileId,
        );
    }

    /**
     * encyclopedia/tankengines; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     * @param list<int> $moduleIds
     * @param list<string> $nation
     * @deprecated WG marks this endpoint deprecated; requires explicit client opt-in.
     */
    public static function tankEngines(
        string|null $language = null,
        array $fields = [],
        array $moduleIds = [],
        array $nation = [],
    ): ApiResult {
        return Wot::client()->encyclopedia()->tankEngines($language, $fields, $moduleIds, $nation);
    }

    /**
     * encyclopedia/tankengines; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     * @param list<int> $moduleIds
     * @param list<string> $nation
     * @deprecated WG marks this endpoint deprecated; requires explicit client opt-in.
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
     * encyclopedia/tankturrets; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     * @param list<int> $moduleIds
     * @param list<string> $nation
     * @deprecated WG marks this endpoint deprecated; requires explicit client opt-in.
     */
    public static function tankTurrets(
        string|null $language = null,
        array $fields = [],
        array $moduleIds = [],
        array $nation = [],
    ): ApiResult {
        return Wot::client()->encyclopedia()->tankTurrets($language, $fields, $moduleIds, $nation);
    }

    /**
     * encyclopedia/tankturrets; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     * @param list<int> $moduleIds
     * @param list<string> $nation
     * @deprecated WG marks this endpoint deprecated; requires explicit client opt-in.
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
     * encyclopedia/tankradios; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     * @param list<int> $moduleIds
     * @param list<string> $nation
     * @deprecated WG marks this endpoint deprecated; requires explicit client opt-in.
     */
    public static function tankRadios(
        string|null $language = null,
        array $fields = [],
        array $moduleIds = [],
        array $nation = [],
    ): ApiResult {
        return Wot::client()->encyclopedia()->tankRadios($language, $fields, $moduleIds, $nation);
    }

    /**
     * encyclopedia/tankradios; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     * @param list<int> $moduleIds
     * @param list<string> $nation
     * @deprecated WG marks this endpoint deprecated; requires explicit client opt-in.
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
     * encyclopedia/tankchassis; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     * @param list<int> $moduleIds
     * @param list<string> $nation
     * @deprecated WG marks this endpoint deprecated; requires explicit client opt-in.
     */
    public static function tankChassis(
        string|null $language = null,
        array $fields = [],
        array $moduleIds = [],
        array $nation = [],
    ): ApiResult {
        return Wot::client()->encyclopedia()->tankChassis($language, $fields, $moduleIds, $nation);
    }

    /**
     * encyclopedia/tankchassis; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     * @param list<int> $moduleIds
     * @param list<string> $nation
     * @deprecated WG marks this endpoint deprecated; requires explicit client opt-in.
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
     * encyclopedia/tankguns; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     * @param list<int> $moduleIds
     * @param list<string> $nation
     * @deprecated WG marks this endpoint deprecated; requires explicit client opt-in.
     */
    public static function tankGuns(
        string|null $language = null,
        array $fields = [],
        array $moduleIds = [],
        array $nation = [],
        int|null $turretId = null,
        int|null $tankId = null,
    ): ApiResult {
        return Wot::client()->encyclopedia()->tankGuns(
            $language,
            $fields,
            $moduleIds,
            $nation,
            $turretId,
            $tankId,
        );
    }

    /**
     * encyclopedia/tankguns; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     * @param list<int> $moduleIds
     * @param list<string> $nation
     * @deprecated WG marks this endpoint deprecated; requires explicit client opt-in.
     */
    public static function prepareTankGuns(
        string|null $language = null,
        array $fields = [],
        array $moduleIds = [],
        array $nation = [],
        int|null $turretId = null,
        int|null $tankId = null,
    ): PreparedOperation {
        return Wot::client()->encyclopedia()->prepareTankGuns(
            $language,
            $fields,
            $moduleIds,
            $nation,
            $turretId,
            $tankId,
        );
    }

    /**
     * encyclopedia/achievements; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     */
    public static function achievements(array $fields = [], string|null $language = null): ApiResult
    {
        return Wot::client()->encyclopedia()->achievements($fields, $language);
    }

    /**
     * encyclopedia/achievements; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     */
    public static function prepareAchievements(array $fields = [], string|null $language = null): PreparedOperation
    {
        return Wot::client()->encyclopedia()->prepareAchievements($fields, $language);
    }

    /**
     * encyclopedia/info; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     */
    public static function info(array $fields = [], string|null $language = null): ApiResult
    {
        return Wot::client()->encyclopedia()->info($fields, $language);
    }

    /**
     * encyclopedia/info; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     */
    public static function prepareInfo(array $fields = [], string|null $language = null): PreparedOperation
    {
        return Wot::client()->encyclopedia()->prepareInfo($fields, $language);
    }

    /**
     * encyclopedia/arenas; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     */
    public static function arenas(array $fields = [], string|null $language = null): ApiResult
    {
        return Wot::client()->encyclopedia()->arenas($fields, $language);
    }

    /**
     * encyclopedia/arenas; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     */
    public static function prepareArenas(array $fields = [], string|null $language = null): PreparedOperation
    {
        return Wot::client()->encyclopedia()->prepareArenas($fields, $language);
    }

    /**
     * encyclopedia/provisions; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     * @param list<string> $type
     * @param list<int> $provisionIds
     */
    public static function provisions(
        array $fields = [],
        string|null $language = null,
        int|null $pageNo = null,
        int|null $limit = null,
        array $type = [],
        array $provisionIds = [],
    ): ApiResult {
        return Wot::client()->encyclopedia()->provisions(
            $fields,
            $language,
            $pageNo,
            $limit,
            $type,
            $provisionIds,
        );
    }

    /**
     * encyclopedia/provisions; see the official reference linked in docs/ENDPOINTS.md.
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
        return Wot::client()->encyclopedia()->prepareProvisions(
            $fields,
            $language,
            $pageNo,
            $limit,
            $type,
            $provisionIds,
        );
    }

    /**
     * encyclopedia/provisions; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     * @param list<string> $type
     * @param list<int> $provisionIds
     * @return Generator<array-key, Record|null>
     */
    public static function iterateProvisions(
        array $fields = [],
        string|null $language = null,
        int|null $limit = null,
        array $type = [],
        array $provisionIds = [],
        int $startPage = 1,
        int $maxPages = 1000,
    ): Generator {
        return Wot::client()->encyclopedia()->iterateProvisions(
            $fields,
            $language,
            $limit,
            $type,
            $provisionIds,
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
    public static function allProvisions(
        array $fields = [],
        string|null $language = null,
        int|null $limit = null,
        array $type = [],
        array $provisionIds = [],
        int $startPage = 1,
        int $maxPages = 1000,
    ): ApiResult {
        return Wot::client()->encyclopedia()->allProvisions(
            $fields,
            $language,
            $limit,
            $type,
            $provisionIds,
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
    public static function personalMissions(
        array $fields = [],
        string|null $language = null,
        array $campaignIds = [],
        array $operationIds = [],
        array $setIds = [],
        array $tag = [],
    ): ApiResult {
        return Wot::client()->encyclopedia()->personalMissions(
            $fields,
            $language,
            $campaignIds,
            $operationIds,
            $setIds,
            $tag,
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
    public static function preparePersonalMissions(
        array $fields = [],
        string|null $language = null,
        array $campaignIds = [],
        array $operationIds = [],
        array $setIds = [],
        array $tag = [],
    ): PreparedOperation {
        return Wot::client()->encyclopedia()->preparePersonalMissions(
            $fields,
            $language,
            $campaignIds,
            $operationIds,
            $setIds,
            $tag,
        );
    }

    /**
     * encyclopedia/boosters; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     */
    public static function boosters(array $fields = [], string|null $language = null): ApiResult
    {
        return Wot::client()->encyclopedia()->boosters($fields, $language);
    }

    /**
     * encyclopedia/boosters; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     */
    public static function prepareBoosters(array $fields = [], string|null $language = null): PreparedOperation
    {
        return Wot::client()->encyclopedia()->prepareBoosters($fields, $language);
    }

    /**
     * encyclopedia/vehicleprofiles; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     */
    public static function vehicleProfiles(
        int $tankId,
        array $fields = [],
        string|null $language = null,
        string|null $orderBy = null,
    ): ApiResult {
        return Wot::client()->encyclopedia()->vehicleProfiles($tankId, $fields, $language, $orderBy);
    }

    /**
     * encyclopedia/vehicleprofiles; see the official reference linked in docs/ENDPOINTS.md.
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
     * encyclopedia/modules; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     * @param list<string> $extra
     * @param list<int> $moduleIds
     * @param list<string> $type
     * @param list<string> $nation
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
    ): ApiResult {
        return Wot::client()->encyclopedia()->modules(
            $fields,
            $extra,
            $language,
            $pageNo,
            $limit,
            $moduleIds,
            $type,
            $nation,
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
        return Wot::client()->encyclopedia()->prepareModules(
            $fields,
            $extra,
            $language,
            $pageNo,
            $limit,
            $moduleIds,
            $type,
            $nation,
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
    public static function iterateModules(
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
        return Wot::client()->encyclopedia()->iterateModules(
            $fields,
            $extra,
            $language,
            $limit,
            $moduleIds,
            $type,
            $nation,
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
    public static function allModules(
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
        return Wot::client()->encyclopedia()->allModules(
            $fields,
            $extra,
            $language,
            $limit,
            $moduleIds,
            $type,
            $nation,
            $startPage,
            $maxPages,
        );
    }

    /**
     * encyclopedia/badges; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     */
    public static function badges(array $fields = [], string|null $language = null): ApiResult
    {
        return Wot::client()->encyclopedia()->badges($fields, $language);
    }

    /**
     * encyclopedia/badges; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     */
    public static function prepareBadges(array $fields = [], string|null $language = null): PreparedOperation
    {
        return Wot::client()->encyclopedia()->prepareBadges($fields, $language);
    }

    /**
     * encyclopedia/crewroles; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     * @param list<string> $role
     */
    public static function crewRoles(array $fields = [], string|null $language = null, array $role = []): ApiResult
    {
        return Wot::client()->encyclopedia()->crewRoles($fields, $language, $role);
    }

    /**
     * encyclopedia/crewroles; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     * @param list<string> $role
     */
    public static function prepareCrewRoles(array $fields = [], string|null $language = null, array $role = []): PreparedOperation
    {
        return Wot::client()->encyclopedia()->prepareCrewRoles($fields, $language, $role);
    }

    /**
     * encyclopedia/crewskills; see the official reference linked in docs/ENDPOINTS.md.
     * @param list<string> $fields
     * @param list<string> $skill
     */
    public static function crewSkills(
        array $fields = [],
        string|null $language = null,
        array $skill = [],
        string|null $role = null,
    ): ApiResult {
        return Wot::client()->encyclopedia()->crewSkills($fields, $language, $skill, $role);
    }

    /**
     * encyclopedia/crewskills; see the official reference linked in docs/ENDPOINTS.md.
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
