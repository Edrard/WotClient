# World of Tanks GET methods

API namespace: `wot`. Catalog snapshot: 2026-09-27. Each method below returns a list of raw per-URL FetchResult objects; it never parses WG JSON.
For ID-list methods, pass K as `batchSize`. The caller chooses K; the client only divides N values into groups of at most K.
Every service method also has a `prepareX()` form with the same arguments for mixed-method `executeMany()` calls. Static facades have the same signatures.

For methods supporting `language`, the request argument overrides the client default. `setLanguage()` changes the default for future calls; prepared operations retain the language resolved at preparation time. See the README for instance and static configuration examples.

Methods marked **Deprecated** in the bundled WG catalog remain callable. The label is informational; the client returns their raw HTTP results as usual.

## account/list

Catalog realms: asia, eu, na.

Instance: `$client->accounts()->search(search: 'Player')`

Static: `Accounts::search(search: 'Player')`

Signature: `search(string $search, string|null $language = null, array $fields = [], string|null $type = null, int|null $limit = null): array`

Official reference: https://developers.wargaming.net/reference/all/wot/account/list/

| WG parameter | Named argument | Required | Type / constraints |
| --- | --- | --- | --- |
| `search` | `search` | Yes | string |
| `language` | `language` | No | string; values: en, ru, pl, de, fr, es, zh-cn, zh-tw, tr, cs, th, vi, ko |
| `fields` | `fields` | No | string, list; max items: 100 |
| `type` | `type` | No | string; values: startswith, exact; min bytes: 3; max bytes: 24 |
| `limit` | `limit` | No | numeric; min: 1; max: 100 |

## account/list: exact nickname batch

Instance: `$client->accounts()->searchExactMany(['PlayerOne', 'PlayerTwo'], batchSize: 2)`

Static: `Accounts::searchExactMany(['PlayerOne', 'PlayerTwo'], batchSize: 2)`

The client splits the names by K and sends the resulting URLs in one getter multirequest.

## account/info

Catalog realms: asia, eu, na.

Instance: `$client->accounts()->info(accountIds: [500000001], batchSize: 25)`

Static: `Accounts::info(accountIds: [500000001], batchSize: 25)`

Signature: `info(array $accountIds, int $batchSize, string|null $language = null, array $fields = [], #[SensitiveParameter] string|null $accessToken = null, array $extra = []): array`

Official reference: https://developers.wargaming.net/reference/all/wot/account/info/

| WG parameter | Named argument | Required | Type / constraints |
| --- | --- | --- | --- |
| `account_id` | `accountIds` | Yes | numeric, list; min: 1; WG list limit (caller chooses K): 100 |
| `language` | `language` | No | string; values: en, ru, pl, de, fr, es, zh-cn, zh-tw, tr, cs, th, vi, ko |
| `fields` | `fields` | No | string, list; max items: 100 |
| `access_token` | `accessToken` | No | string |
| `extra` | `extra` | No | string, list; values: private.boosters, private.garage, private.grouped_contacts, private.personal_missions, private.rented, statistics.epic, statistics.fallout, statistics.globalmap_absolute, statistics.globalmap_champion, statistics.globalmap_middle, statistics.random, statistics.ranked_10x10, statistics.ranked_15x15, statistics.ranked_battles, statistics.ranked_battles_current, statistics.ranked_battles_previous, statistics.ranked_season_1, statistics.ranked_season_2, statistics.ranked_season_3 |
| Client grouping | `batchSize` | Yes | Positive integer K, chosen by caller. |

## account/tanks

Catalog realms: asia, eu, na.

Instance: `$client->accounts()->tanks(accountIds: [500000001], batchSize: 25)`

Static: `Accounts::tanks(accountIds: [500000001], batchSize: 25)`

Signature: `tanks(array $accountIds, int $batchSize, string|null $language = null, array $fields = [], #[SensitiveParameter] string|null $accessToken = null, array $tankIds = []): array`

Official reference: https://developers.wargaming.net/reference/all/wot/account/tanks/

| WG parameter | Named argument | Required | Type / constraints |
| --- | --- | --- | --- |
| `account_id` | `accountIds` | Yes | numeric, list; min: 1; WG list limit (caller chooses K): 100 |
| `language` | `language` | No | string; values: en, ru, pl, de, fr, es, zh-cn, zh-tw, tr, cs, th, vi, ko |
| `fields` | `fields` | No | string, list; max items: 100 |
| `access_token` | `accessToken` | No | string |
| `tank_id` | `tankIds` | No | numeric, list; min: 1; max items: 100 |
| Client grouping | `batchSize` | Yes | Positive integer K, chosen by caller. |

## account/achievements

Catalog realms: asia, eu, na.

Instance: `$client->accounts()->achievements(accountIds: [500000001], batchSize: 25)`

Static: `Accounts::achievements(accountIds: [500000001], batchSize: 25)`

Signature: `achievements(array $accountIds, int $batchSize, string|null $language = null, array $fields = []): array`

Official reference: https://developers.wargaming.net/reference/all/wot/account/achievements/

| WG parameter | Named argument | Required | Type / constraints |
| --- | --- | --- | --- |
| `account_id` | `accountIds` | Yes | numeric, list; min: 1; WG list limit (caller chooses K): 100 |
| `language` | `language` | No | string; values: en, ru, pl, de, fr, es, zh-cn, zh-tw, tr, cs, th, vi, ko |
| `fields` | `fields` | No | string, list; max items: 100 |
| Client grouping | `batchSize` | Yes | Positive integer K, chosen by caller. |

## account/wtr

Catalog realms: asia, eu, na.

Instance: `$client->accounts()->wtr(accountIds: [500000001], batchSize: 25)`

Static: `Accounts::wtr(accountIds: [500000001], batchSize: 25)`

Signature: `wtr(array $accountIds, int $batchSize, string|null $language = null, array $fields = []): array`

Official reference: https://developers.wargaming.net/reference/all/wot/account/wtr/

| WG parameter | Named argument | Required | Type / constraints |
| --- | --- | --- | --- |
| `account_id` | `accountIds` | Yes | numeric, list; min: 1; WG list limit (caller chooses K): 100 |
| `language` | `language` | No | string; values: en, ru, pl, de, fr, es, zh-cn, zh-tw, tr, cs, th, vi, ko |
| `fields` | `fields` | No | string, list; max items: 100 |
| Client grouping | `batchSize` | Yes | Positive integer K, chosen by caller. |

## tanks/stats

Catalog realms: asia, eu, na.

Instance: `$client->tanks()->stats(accountId: 1)`

Static: `Tanks::stats(accountId: 1)`

Signature: `stats(int $accountId, string|null $language = null, array $fields = [], #[SensitiveParameter] string|null $accessToken = null, array $extra = [], array $tankIds = [], string|null $inGarage = null): array`

Official reference: https://developers.wargaming.net/reference/all/wot/tanks/stats/

| WG parameter | Named argument | Required | Type / constraints |
| --- | --- | --- | --- |
| `account_id` | `accountId` | Yes | numeric; min: 1 |
| `language` | `language` | No | string; values: en, ru, pl, de, fr, es, zh-cn, zh-tw, tr, cs, th, vi, ko |
| `fields` | `fields` | No | string, list; max items: 100 |
| `access_token` | `accessToken` | No | string |
| `extra` | `extra` | No | string, list; values: epic, fallout, random, ranked_10x10, ranked_battles |
| `tank_id` | `tankIds` | No | numeric, list; min: 1; max items: 100 |
| `in_garage` | `inGarage` | No | string; values: 1, 0 |

## tanks/achievements

Catalog realms: asia, eu, na.

Instance: `$client->tanks()->achievements(accountId: 1)`

Static: `Tanks::achievements(accountId: 1)`

Signature: `achievements(int $accountId, string|null $language = null, array $fields = [], #[SensitiveParameter] string|null $accessToken = null, array $tankIds = [], string|null $inGarage = null): array`

Official reference: https://developers.wargaming.net/reference/all/wot/tanks/achievements/

| WG parameter | Named argument | Required | Type / constraints |
| --- | --- | --- | --- |
| `account_id` | `accountId` | Yes | numeric; min: 1 |
| `language` | `language` | No | string; values: en, ru, pl, de, fr, es, zh-cn, zh-tw, tr, cs, th, vi, ko |
| `fields` | `fields` | No | string, list; max items: 100 |
| `access_token` | `accessToken` | No | string |
| `tank_id` | `tankIds` | No | numeric, list; min: 1; max items: 100 |
| `in_garage` | `inGarage` | No | string; values: 1, 0 |

## tanks/mastery

Catalog realms: asia, eu, na.

Instance: `$client->tanks()->mastery(distribution: 'damage', percentile: [95])`

Static: `Tanks::mastery(distribution: 'damage', percentile: [95])`

Signature: `mastery(string $distribution, array $percentile, string|null $language = null, array $fields = [], array $tankIds = []): array`

Official reference: https://developers.wargaming.net/reference/all/wot/tanks/mastery/

| WG parameter | Named argument | Required | Type / constraints |
| --- | --- | --- | --- |
| `distribution` | `distribution` | Yes | string; values: damage, xp |
| `percentile` | `percentile` | Yes | numeric, list; min: 0; max: 100; max items: 10 |
| `language` | `language` | No | string; values: en, ru, pl, de, fr, es, zh-cn, zh-tw, tr, cs, th, vi, ko |
| `fields` | `fields` | No | string, list; max items: 100 |
| `tank_id` | `tankIds` | No | numeric, list; min: 1; max items: 100 |

## encyclopedia/tanks

Catalog realms: asia, eu, na.

**Deprecated:** marked deprecated in the WG catalog. This method remains callable and returns raw HTTP results.

Instance: `$client->encyclopedia()->tanks()`

Static: `Encyclopedia::tanks()`

Signature: `tanks(string|null $language = null, array $fields = []): array`

Official reference: https://developers.wargaming.net/reference/all/wot/encyclopedia/tanks/

| WG parameter | Named argument | Required | Type / constraints |
| --- | --- | --- | --- |
| `language` | `language` | No | string; values: en, ru, pl, de, fr, es, zh-cn, zh-tw, tr, cs, th, vi, ko |
| `fields` | `fields` | No | string, list; max items: 100 |

## encyclopedia/tankinfo

Catalog realms: asia, eu, na.

**Deprecated:** marked deprecated in the WG catalog. This method remains callable and returns raw HTTP results.

Instance: `$client->encyclopedia()->tankInfo(tankIds: [500000001], batchSize: 25)`

Static: `Encyclopedia::tankInfo(tankIds: [500000001], batchSize: 25)`

Signature: `tankInfo(array $tankIds, int $batchSize, string|null $language = null, array $fields = []): array`

Official reference: https://developers.wargaming.net/reference/all/wot/encyclopedia/tankinfo/

| WG parameter | Named argument | Required | Type / constraints |
| --- | --- | --- | --- |
| `tank_id` | `tankIds` | Yes | numeric, list; min: 1; WG list limit (caller chooses K): 1000 |
| `language` | `language` | No | string; values: en, ru, pl, de, fr, es, zh-cn, zh-tw, tr, cs, th, vi, ko |
| `fields` | `fields` | No | string, list; max items: 100 |
| Client grouping | `batchSize` | Yes | Positive integer K, chosen by caller. |

## encyclopedia/vehicles

Catalog realms: asia, eu, na.

Instance: `$client->encyclopedia()->vehicles()`

Static: `Encyclopedia::vehicles()`

Signature: `vehicles(array $fields = [], string|null $language = null, int|null $pageNo = null, int|null $limit = null, array $tankIds = [], array $nation = [], array $type = [], array $tier = []): array`

Official reference: https://developers.wargaming.net/reference/all/wot/encyclopedia/vehicles/

| WG parameter | Named argument | Required | Type / constraints |
| --- | --- | --- | --- |
| `fields` | `fields` | No | string, list; max items: 100 |
| `language` | `language` | No | string; values: en, ru, pl, de, fr, es, zh-cn, zh-tw, tr, cs, th, vi, ko |
| `page_no` | `pageNo` | No | numeric; min: 1 |
| `limit` | `limit` | No | numeric; min: 1; max: 100 |
| `tank_id` | `tankIds` | No | numeric, list; min: 1; max items: 100 |
| `nation` | `nation` | No | string, list; max items: 100 |
| `type` | `type` | No | string, list; values: heavyTank, AT-SPG, mediumTank, lightTank, SPG; max items: 100 |
| `tier` | `tier` | No | numeric, list; min: 1; max items: 100 |

## encyclopedia/vehicleprofile

Catalog realms: asia, eu, na.

Instance: `$client->encyclopedia()->vehicleProfile(tankId: 1)`

Static: `Encyclopedia::vehicleProfile(tankId: 1)`

Signature: `vehicleProfile(int $tankId, array $fields = [], string|null $language = null, int|null $engineId = null, int|null $gunId = null, int|null $suspensionId = null, int|null $turretId = null, int|null $radioId = null, string|null $profileId = null): array`

Official reference: https://developers.wargaming.net/reference/all/wot/encyclopedia/vehicleprofile/

| WG parameter | Named argument | Required | Type / constraints |
| --- | --- | --- | --- |
| `tank_id` | `tankId` | Yes | numeric; min: 1 |
| `fields` | `fields` | No | string, list; max items: 100 |
| `language` | `language` | No | string; values: en, ru, pl, de, fr, es, zh-cn, zh-tw, tr, cs, th, vi, ko |
| `engine_id` | `engineId` | No | numeric; min: 1 |
| `gun_id` | `gunId` | No | numeric; min: 1 |
| `suspension_id` | `suspensionId` | No | numeric; min: 1 |
| `turret_id` | `turretId` | No | numeric; min: 1 |
| `radio_id` | `radioId` | No | numeric; min: 1 |
| `profile_id` | `profileId` | No | string |

## encyclopedia/tankengines

Catalog realms: asia, eu, na.

**Deprecated:** marked deprecated in the WG catalog. This method remains callable and returns raw HTTP results.

Instance: `$client->encyclopedia()->tankEngines()`

Static: `Encyclopedia::tankEngines()`

Signature: `tankEngines(string|null $language = null, array $fields = [], array $moduleIds = [], array $nation = []): array`

Official reference: https://developers.wargaming.net/reference/all/wot/encyclopedia/tankengines/

| WG parameter | Named argument | Required | Type / constraints |
| --- | --- | --- | --- |
| `language` | `language` | No | string; values: en, ru, pl, de, fr, es, zh-cn, zh-tw, tr, cs, th, vi, ko |
| `fields` | `fields` | No | string, list; max items: 100 |
| `module_id` | `moduleIds` | No | numeric, list; min: 1; max items: 1000 |
| `nation` | `nation` | No | string, list; max items: 100 |

## encyclopedia/tankturrets

Catalog realms: asia, eu, na.

**Deprecated:** marked deprecated in the WG catalog. This method remains callable and returns raw HTTP results.

Instance: `$client->encyclopedia()->tankTurrets()`

Static: `Encyclopedia::tankTurrets()`

Signature: `tankTurrets(string|null $language = null, array $fields = [], array $moduleIds = [], array $nation = []): array`

Official reference: https://developers.wargaming.net/reference/all/wot/encyclopedia/tankturrets/

| WG parameter | Named argument | Required | Type / constraints |
| --- | --- | --- | --- |
| `language` | `language` | No | string; values: en, ru, pl, de, fr, es, zh-cn, zh-tw, tr, cs, th, vi, ko |
| `fields` | `fields` | No | string, list; max items: 100 |
| `module_id` | `moduleIds` | No | numeric, list; min: 1; max items: 1000 |
| `nation` | `nation` | No | string, list; max items: 100 |

## encyclopedia/tankradios

Catalog realms: asia, eu, na.

**Deprecated:** marked deprecated in the WG catalog. This method remains callable and returns raw HTTP results.

Instance: `$client->encyclopedia()->tankRadios()`

Static: `Encyclopedia::tankRadios()`

Signature: `tankRadios(string|null $language = null, array $fields = [], array $moduleIds = [], array $nation = []): array`

Official reference: https://developers.wargaming.net/reference/all/wot/encyclopedia/tankradios/

| WG parameter | Named argument | Required | Type / constraints |
| --- | --- | --- | --- |
| `language` | `language` | No | string; values: en, ru, pl, de, fr, es, zh-cn, zh-tw, tr, cs, th, vi, ko |
| `fields` | `fields` | No | string, list; max items: 100 |
| `module_id` | `moduleIds` | No | numeric, list; min: 1; max items: 1000 |
| `nation` | `nation` | No | string, list; max items: 100 |

## encyclopedia/tankchassis

Catalog realms: asia, eu, na.

**Deprecated:** marked deprecated in the WG catalog. This method remains callable and returns raw HTTP results.

Instance: `$client->encyclopedia()->tankChassis()`

Static: `Encyclopedia::tankChassis()`

Signature: `tankChassis(string|null $language = null, array $fields = [], array $moduleIds = [], array $nation = []): array`

Official reference: https://developers.wargaming.net/reference/all/wot/encyclopedia/tankchassis/

| WG parameter | Named argument | Required | Type / constraints |
| --- | --- | --- | --- |
| `language` | `language` | No | string; values: en, ru, pl, de, fr, es, zh-cn, zh-tw, tr, cs, th, vi, ko |
| `fields` | `fields` | No | string, list; max items: 100 |
| `module_id` | `moduleIds` | No | numeric, list; min: 1; max items: 1000 |
| `nation` | `nation` | No | string, list; max items: 100 |

## encyclopedia/tankguns

Catalog realms: asia, eu, na.

**Deprecated:** marked deprecated in the WG catalog. This method remains callable and returns raw HTTP results.

Instance: `$client->encyclopedia()->tankGuns()`

Static: `Encyclopedia::tankGuns()`

Signature: `tankGuns(string|null $language = null, array $fields = [], array $moduleIds = [], array $nation = [], int|null $turretId = null, int|null $tankId = null): array`

Official reference: https://developers.wargaming.net/reference/all/wot/encyclopedia/tankguns/

| WG parameter | Named argument | Required | Type / constraints |
| --- | --- | --- | --- |
| `language` | `language` | No | string; values: en, ru, pl, de, fr, es, zh-cn, zh-tw, tr, cs, th, vi, ko |
| `fields` | `fields` | No | string, list; max items: 100 |
| `module_id` | `moduleIds` | No | numeric, list; min: 1; max items: 1000 |
| `nation` | `nation` | No | string, list; max items: 100 |
| `turret_id` | `turretId` | No | numeric; min: 1 |
| `tank_id` | `tankId` | No | numeric; min: 1 |

## encyclopedia/achievements

Catalog realms: asia, eu, na.

Instance: `$client->encyclopedia()->achievements()`

Static: `Encyclopedia::achievements()`

Signature: `achievements(array $fields = [], string|null $language = null): array`

Official reference: https://developers.wargaming.net/reference/all/wot/encyclopedia/achievements/

| WG parameter | Named argument | Required | Type / constraints |
| --- | --- | --- | --- |
| `fields` | `fields` | No | string, list; max items: 100 |
| `language` | `language` | No | string; values: en, ru, pl, de, fr, es, zh-cn, zh-tw, tr, cs, th, vi, ko |

## encyclopedia/info

Catalog realms: asia, eu, na.

Instance: `$client->encyclopedia()->info()`

Static: `Encyclopedia::info()`

Signature: `info(array $fields = [], string|null $language = null): array`

Official reference: https://developers.wargaming.net/reference/all/wot/encyclopedia/info/

| WG parameter | Named argument | Required | Type / constraints |
| --- | --- | --- | --- |
| `fields` | `fields` | No | string, list; max items: 100 |
| `language` | `language` | No | string; values: en, ru, pl, de, fr, es, zh-cn, zh-tw, tr, cs, th, vi, ko |

## encyclopedia/arenas

Catalog realms: asia, eu, na.

Instance: `$client->encyclopedia()->arenas()`

Static: `Encyclopedia::arenas()`

Signature: `arenas(array $fields = [], string|null $language = null): array`

Official reference: https://developers.wargaming.net/reference/all/wot/encyclopedia/arenas/

| WG parameter | Named argument | Required | Type / constraints |
| --- | --- | --- | --- |
| `fields` | `fields` | No | string, list; max items: 100 |
| `language` | `language` | No | string; values: en, ru, pl, de, fr, es, zh-cn, zh-tw, tr, cs, th, vi, ko |

## encyclopedia/provisions

Catalog realms: asia, eu, na.

Instance: `$client->encyclopedia()->provisions()`

Static: `Encyclopedia::provisions()`

Signature: `provisions(array $fields = [], string|null $language = null, int|null $pageNo = null, int|null $limit = null, array $type = [], array $provisionIds = []): array`

Official reference: https://developers.wargaming.net/reference/all/wot/encyclopedia/provisions/

| WG parameter | Named argument | Required | Type / constraints |
| --- | --- | --- | --- |
| `fields` | `fields` | No | string, list; max items: 100 |
| `language` | `language` | No | string; values: en, ru, pl, de, fr, es, zh-cn, zh-tw, tr, cs, th, vi, ko |
| `page_no` | `pageNo` | No | numeric; min: 1 |
| `limit` | `limit` | No | numeric; min: 1; max: 100 |
| `type` | `type` | No | string, list; values: equipment, optionalDevice; max items: 100 |
| `provision_id` | `provisionIds` | No | numeric, list; min: 1; max items: 100 |

## encyclopedia/personalmissions

Catalog realms: asia, eu, na.

Instance: `$client->encyclopedia()->personalMissions()`

Static: `Encyclopedia::personalMissions()`

Signature: `personalMissions(array $fields = [], string|null $language = null, array $campaignIds = [], array $operationIds = [], array $setIds = [], array $tag = []): array`

Official reference: https://developers.wargaming.net/reference/all/wot/encyclopedia/personalmissions/

| WG parameter | Named argument | Required | Type / constraints |
| --- | --- | --- | --- |
| `fields` | `fields` | No | string, list; max items: 100 |
| `language` | `language` | No | string; values: en, ru, pl, de, fr, es, zh-cn, zh-tw, tr, cs, th, vi, ko |
| `campaign_id` | `campaignIds` | No | numeric, list; min: 1; max items: 100 |
| `operation_id` | `operationIds` | No | numeric, list; min: 1; max items: 100 |
| `set_id` | `setIds` | No | numeric, list; min: 1; max items: 100 |
| `tag` | `tag` | No | string, list; max items: 100 |

## encyclopedia/boosters

Catalog realms: asia, eu, na.

Instance: `$client->encyclopedia()->boosters()`

Static: `Encyclopedia::boosters()`

Signature: `boosters(array $fields = [], string|null $language = null): array`

Official reference: https://developers.wargaming.net/reference/all/wot/encyclopedia/boosters/

| WG parameter | Named argument | Required | Type / constraints |
| --- | --- | --- | --- |
| `fields` | `fields` | No | string, list; max items: 100 |
| `language` | `language` | No | string; values: en, ru, pl, de, fr, es, zh-cn, zh-tw, tr, cs, th, vi, ko |

## encyclopedia/vehicleprofiles

Catalog realms: asia, eu, na.

Instance: `$client->encyclopedia()->vehicleProfiles(tankId: 1)`

Static: `Encyclopedia::vehicleProfiles(tankId: 1)`

Signature: `vehicleProfiles(int $tankId, array $fields = [], string|null $language = null, string|null $orderBy = null): array`

Official reference: https://developers.wargaming.net/reference/all/wot/encyclopedia/vehicleprofiles/

| WG parameter | Named argument | Required | Type / constraints |
| --- | --- | --- | --- |
| `tank_id` | `tankId` | Yes | numeric; min: 1 |
| `fields` | `fields` | No | string, list; max items: 100 |
| `language` | `language` | No | string; values: en, ru, pl, de, fr, es, zh-cn, zh-tw, tr, cs, th, vi, ko |
| `order_by` | `orderBy` | No | string; values: price_credit, -price_credit |

## encyclopedia/modules

Catalog realms: asia, eu, na.

Instance: `$client->encyclopedia()->modules()`

Static: `Encyclopedia::modules()`

Signature: `modules(array $fields = [], array $extra = [], string|null $language = null, int|null $pageNo = null, int|null $limit = null, array $moduleIds = [], array $type = [], array $nation = []): array`

Official reference: https://developers.wargaming.net/reference/all/wot/encyclopedia/modules/

| WG parameter | Named argument | Required | Type / constraints |
| --- | --- | --- | --- |
| `fields` | `fields` | No | string, list; max items: 100 |
| `extra` | `extra` | No | string, list; values: default_profile |
| `language` | `language` | No | string; values: en, ru, pl, de, fr, es, zh-cn, zh-tw, tr, cs, th, vi, ko |
| `page_no` | `pageNo` | No | numeric; min: 1 |
| `limit` | `limit` | No | numeric; min: 1; max: 100 |
| `module_id` | `moduleIds` | No | numeric, list; min: 1; max items: 100 |
| `type` | `type` | No | string, list; values: vehicleRadio, vehicleEngine, vehicleGun, vehicleChassis, vehicleTurret; max items: 100 |
| `nation` | `nation` | No | string, list; max items: 100 |

## encyclopedia/badges

Catalog realms: asia, eu, na.

Instance: `$client->encyclopedia()->badges()`

Static: `Encyclopedia::badges()`

Signature: `badges(array $fields = [], string|null $language = null): array`

Official reference: https://developers.wargaming.net/reference/all/wot/encyclopedia/badges/

| WG parameter | Named argument | Required | Type / constraints |
| --- | --- | --- | --- |
| `fields` | `fields` | No | string, list; max items: 100 |
| `language` | `language` | No | string; values: en, ru, pl, de, fr, es, zh-cn, zh-tw, tr, cs, th, vi, ko |

## encyclopedia/crewroles

Catalog realms: asia, eu, na.

Instance: `$client->encyclopedia()->crewRoles()`

Static: `Encyclopedia::crewRoles()`

Signature: `crewRoles(array $fields = [], string|null $language = null, array $role = []): array`

Official reference: https://developers.wargaming.net/reference/all/wot/encyclopedia/crewroles/

| WG parameter | Named argument | Required | Type / constraints |
| --- | --- | --- | --- |
| `fields` | `fields` | No | string, list; max items: 100 |
| `language` | `language` | No | string; values: en, ru, pl, de, fr, es, zh-cn, zh-tw, tr, cs, th, vi, ko |
| `role` | `role` | No | string, list; max items: 100 |

## encyclopedia/crewskills

Catalog realms: asia, eu, na.

Instance: `$client->encyclopedia()->crewSkills()`

Static: `Encyclopedia::crewSkills()`

Signature: `crewSkills(array $fields = [], string|null $language = null, array $skill = [], string|null $role = null): array`

Official reference: https://developers.wargaming.net/reference/all/wot/encyclopedia/crewskills/

| WG parameter | Named argument | Required | Type / constraints |
| --- | --- | --- | --- |
| `fields` | `fields` | No | string, list; max items: 100 |
| `language` | `language` | No | string; values: en, ru, pl, de, fr, es, zh-cn, zh-tw, tr, cs, th, vi, ko |
| `skill` | `skill` | No | string, list; max items: 100 |
| `role` | `role` | No | string |

## clans/list

Catalog realms: asia, eu, na.

Instance: `$client->clans()->search()`

Static: `Clans::search()`

Signature: `search(string|null $language = null, array $fields = [], string|null $search = null, int|null $limit = null, int|null $pageNo = null): array`

Official reference: https://developers.wargaming.net/reference/all/wot/clans/list/

| WG parameter | Named argument | Required | Type / constraints |
| --- | --- | --- | --- |
| `language` | `language` | No | string; values: en, ru, pl, de, fr, es, zh-cn, zh-tw, tr, cs, th, vi, ko |
| `fields` | `fields` | No | string, list; max items: 100 |
| `search` | `search` | No | string; min bytes: 2 |
| `limit` | `limit` | No | numeric; min: 1; max: 100 |
| `page_no` | `pageNo` | No | numeric; min: 1 |

## clans/info

Catalog realms: asia, eu, na.

Instance: `$client->clans()->info(clanIds: [500000001], batchSize: 25)`

Static: `Clans::info(clanIds: [500000001], batchSize: 25)`

Signature: `info(array $clanIds, int $batchSize, string|null $language = null, array $fields = [], #[SensitiveParameter] string|null $accessToken = null, array $extra = [], string|null $membersKey = null): array`

Official reference: https://developers.wargaming.net/reference/all/wot/clans/info/

| WG parameter | Named argument | Required | Type / constraints |
| --- | --- | --- | --- |
| `clan_id` | `clanIds` | Yes | numeric, list; min: 1; WG list limit (caller chooses K): 100 |
| `language` | `language` | No | string; values: en, ru, pl, de, fr, es, zh-cn, zh-tw, tr, cs, th, vi, ko |
| `fields` | `fields` | No | string, list; max items: 100 |
| `access_token` | `accessToken` | No | string |
| `extra` | `extra` | No | string, list; values: private.online_members |
| `members_key` | `membersKey` | No | string; values: id |
| Client grouping | `batchSize` | Yes | Positive integer K, chosen by caller. |

## clans/accountinfo

Catalog realms: asia, eu, na.

Instance: `$client->clans()->accountInfo(accountIds: [500000001], batchSize: 25)`

Static: `Clans::accountInfo(accountIds: [500000001], batchSize: 25)`

Signature: `accountInfo(array $accountIds, int $batchSize, string|null $language = null, array $fields = []): array`

Official reference: https://developers.wargaming.net/reference/all/wot/clans/accountinfo/

| WG parameter | Named argument | Required | Type / constraints |
| --- | --- | --- | --- |
| `account_id` | `accountIds` | Yes | numeric, list; min: 1; WG list limit (caller chooses K): 100 |
| `language` | `language` | No | string; values: en, ru, pl, de, fr, es, zh-cn, zh-tw, tr, cs, th, vi, ko |
| `fields` | `fields` | No | string, list; max items: 100 |
| Client grouping | `batchSize` | Yes | Positive integer K, chosen by caller. |

## clans/glossary

Catalog realms: asia, eu, na.

Instance: `$client->clans()->glossary()`

Static: `Clans::glossary()`

Signature: `glossary(string|null $language = null, array $fields = []): array`

Official reference: https://developers.wargaming.net/reference/all/wot/clans/glossary/

| WG parameter | Named argument | Required | Type / constraints |
| --- | --- | --- | --- |
| `language` | `language` | No | string; values: en, ru, pl, de, fr, es, zh-cn, zh-tw, tr, cs, th, vi, ko |
| `fields` | `fields` | No | string, list; max items: 100 |

## clans/messageboard

Catalog realms: asia, eu, na.

Instance: `$client->clans()->messageboard(accessToken: 'example')`

Static: `Clans::messageboard(accessToken: 'example')`

Signature: `messageboard(#[SensitiveParameter] string $accessToken, array $fields = []): array`

Official reference: https://developers.wargaming.net/reference/all/wot/clans/messageboard/

| WG parameter | Named argument | Required | Type / constraints |
| --- | --- | --- | --- |
| `access_token` | `accessToken` | Yes | string |
| `fields` | `fields` | No | string, list; max items: 100 |

## clans/memberhistory

Catalog realms: asia, eu, na.

Instance: `$client->clans()->memberHistory(accountId: 1)`

Static: `Clans::memberHistory(accountId: 1)`

Signature: `memberHistory(int $accountId, string|null $language = null, array $fields = []): array`

Official reference: https://developers.wargaming.net/reference/all/wot/clans/memberhistory/

| WG parameter | Named argument | Required | Type / constraints |
| --- | --- | --- | --- |
| `account_id` | `accountId` | Yes | numeric; min: 1 |
| `language` | `language` | No | string; values: en, ru, pl, de, fr, es, zh-cn, zh-tw, tr, cs, th, vi, ko |
| `fields` | `fields` | No | string, list; max items: 100 |

## clanratings/types

Catalog realms: asia, eu, na.

Instance: `$client->clanRatings()->types()`

Static: `ClanRatings::types()`

Signature: `types(): array`

Official reference: https://developers.wargaming.net/reference/all/wot/clanratings/types/

| WG parameter | Named argument | Required | Type / constraints |
| --- | --- | --- | --- |

## clanratings/dates

Catalog realms: asia, eu, na.

Instance: `$client->clanRatings()->dates()`

Static: `ClanRatings::dates()`

Signature: `dates(int|null $limit = null): array`

Official reference: https://developers.wargaming.net/reference/all/wot/clanratings/dates/

| WG parameter | Named argument | Required | Type / constraints |
| --- | --- | --- | --- |
| `limit` | `limit` | No | numeric; min: 1; max: 365 |

## clanratings/clans

Catalog realms: asia, eu, na.

Instance: `$client->clanRatings()->clans(clanIds: [500000001], batchSize: 25)`

Static: `ClanRatings::clans(clanIds: [500000001], batchSize: 25)`

Signature: `clans(array $clanIds, int $batchSize, string|null $language = null, array $fields = [], int|string|null $date = null): array`

Official reference: https://developers.wargaming.net/reference/all/wot/clanratings/clans/

| WG parameter | Named argument | Required | Type / constraints |
| --- | --- | --- | --- |
| `clan_id` | `clanIds` | Yes | numeric, list; min: 1; WG list limit (caller chooses K): 100 |
| `language` | `language` | No | string; values: en, ru, pl, de, fr, es, zh-cn, zh-tw, tr, cs, th, vi, ko |
| `fields` | `fields` | No | string, list; max items: 100 |
| `date` | `date` | No | timestamp/date |
| Client grouping | `batchSize` | Yes | Positive integer K, chosen by caller. |

## clanratings/neighbors

Catalog realms: asia, eu, na.

Instance: `$client->clanRatings()->neighbors(rankField: 'example', clanId: 1)`

Static: `ClanRatings::neighbors(rankField: 'example', clanId: 1)`

Signature: `neighbors(string $rankField, int $clanId, string|null $language = null, array $fields = [], int|string|null $date = null, int|null $limit = null): array`

Official reference: https://developers.wargaming.net/reference/all/wot/clanratings/neighbors/

| WG parameter | Named argument | Required | Type / constraints |
| --- | --- | --- | --- |
| `rank_field` | `rankField` | Yes | string |
| `clan_id` | `clanId` | Yes | numeric; min: 1 |
| `language` | `language` | No | string; values: en, ru, pl, de, fr, es, zh-cn, zh-tw, tr, cs, th, vi, ko |
| `fields` | `fields` | No | string, list; max items: 100 |
| `date` | `date` | No | timestamp/date |
| `limit` | `limit` | No | numeric; min: 1; max: 50 |

## clanratings/top

Catalog realms: asia, eu, na.

Instance: `$client->clanRatings()->top(rankField: 'example')`

Static: `ClanRatings::top(rankField: 'example')`

Signature: `top(string $rankField, string|null $language = null, array $fields = [], int|string|null $date = null, int|null $pageNo = null, int|null $limit = null): array`

Official reference: https://developers.wargaming.net/reference/all/wot/clanratings/top/

| WG parameter | Named argument | Required | Type / constraints |
| --- | --- | --- | --- |
| `rank_field` | `rankField` | Yes | string |
| `language` | `language` | No | string; values: en, ru, pl, de, fr, es, zh-cn, zh-tw, tr, cs, th, vi, ko |
| `fields` | `fields` | No | string, list; max items: 100 |
| `date` | `date` | No | timestamp/date |
| `page_no` | `pageNo` | No | numeric; min: 1 |
| `limit` | `limit` | No | numeric; min: 1; max: 1000 |

## globalmap/fronts

Catalog realms: asia, eu, na.

Instance: `$client->globalMap()->fronts()`

Static: `GlobalMap::fronts()`

Signature: `fronts(array $fields = [], string|null $language = null, int|null $limit = null, int|null $pageNo = null, array $frontIds = []): array`

Official reference: https://developers.wargaming.net/reference/all/wot/globalmap/fronts/

| WG parameter | Named argument | Required | Type / constraints |
| --- | --- | --- | --- |
| `fields` | `fields` | No | string, list; max items: 100 |
| `language` | `language` | No | string; values: en, de, fr, es, pl, tr |
| `limit` | `limit` | No | numeric; min: 1; max: 100 |
| `page_no` | `pageNo` | No | numeric; min: 1 |
| `front_id` | `frontIds` | No | string, list; max items: 100 |

## globalmap/provinces

Catalog realms: asia, eu, na.

Instance: `$client->globalMap()->provinces(frontId: 'example')`

Static: `GlobalMap::provinces(frontId: 'example')`

Signature: `provinces(string $frontId, array $fields = [], string|null $language = null, int|null $limit = null, int|null $pageNo = null, int|null $primeHour = null, string|null $landingType = null, string|null $arenaId = null, int|null $dailyRevenueLte = null, int|null $dailyRevenueGte = null, string|null $orderBy = null, array $provinceIds = []): array`

Official reference: https://developers.wargaming.net/reference/all/wot/globalmap/provinces/

| WG parameter | Named argument | Required | Type / constraints |
| --- | --- | --- | --- |
| `front_id` | `frontId` | Yes | string |
| `fields` | `fields` | No | string, list; max items: 100 |
| `language` | `language` | No | string; values: en, de, fr, es, pl, tr |
| `limit` | `limit` | No | numeric; min: 1; max: 100 |
| `page_no` | `pageNo` | No | numeric; min: 1 |
| `prime_hour` | `primeHour` | No | numeric; min: 0; max: 23 |
| `landing_type` | `landingType` | No | string; values: null, auction, tournament |
| `arena_id` | `arenaId` | No | string |
| `daily_revenue_lte` | `dailyRevenueLte` | No | numeric; min: 0 |
| `daily_revenue_gte` | `dailyRevenueGte` | No | numeric; min: 0 |
| `order_by` | `orderBy` | No | string; values: province_id, -province_id, daily_revenue, -daily_revenue, prime_hour, -prime_hour |
| `province_id` | `provinceIds` | No | string, list; max items: 100 |

## globalmap/claninfo

Catalog realms: asia, eu, na.

Instance: `$client->globalMap()->clanInfo(clanIds: [500000001], batchSize: 25)`

Static: `GlobalMap::clanInfo(clanIds: [500000001], batchSize: 25)`

Signature: `clanInfo(array $clanIds, int $batchSize, array $fields = [], #[SensitiveParameter] string|null $accessToken = null): array`

Official reference: https://developers.wargaming.net/reference/all/wot/globalmap/claninfo/

| WG parameter | Named argument | Required | Type / constraints |
| --- | --- | --- | --- |
| `clan_id` | `clanIds` | Yes | numeric, list; min: 1; WG list limit (caller chooses K): 10 |
| `fields` | `fields` | No | string, list; max items: 100 |
| `access_token` | `accessToken` | No | string |
| Client grouping | `batchSize` | Yes | Positive integer K, chosen by caller. |

## globalmap/clanprovinces

Catalog realms: asia, eu, na.

Instance: `$client->globalMap()->clanProvinces(clanIds: [500000001], batchSize: 25)`

Static: `GlobalMap::clanProvinces(clanIds: [500000001], batchSize: 25)`

Signature: `clanProvinces(array $clanIds, int $batchSize, array $fields = [], #[SensitiveParameter] string|null $accessToken = null, string|null $language = null): array`

Official reference: https://developers.wargaming.net/reference/all/wot/globalmap/clanprovinces/

| WG parameter | Named argument | Required | Type / constraints |
| --- | --- | --- | --- |
| `clan_id` | `clanIds` | Yes | numeric, list; min: 1; WG list limit (caller chooses K): 10 |
| `fields` | `fields` | No | string, list; max items: 100 |
| `access_token` | `accessToken` | No | string |
| `language` | `language` | No | string; values: en, de, fr, es, pl, tr |
| Client grouping | `batchSize` | Yes | Positive integer K, chosen by caller. |

## globalmap/clanbattles

Catalog realms: asia, eu, na.

Instance: `$client->globalMap()->clanBattles(clanId: 1)`

Static: `GlobalMap::clanBattles(clanId: 1)`

Signature: `clanBattles(int $clanId, array $fields = [], string|null $language = null, int|null $limit = null, int|null $pageNo = null): array`

Official reference: https://developers.wargaming.net/reference/all/wot/globalmap/clanbattles/

| WG parameter | Named argument | Required | Type / constraints |
| --- | --- | --- | --- |
| `clan_id` | `clanId` | Yes | numeric; min: 1 |
| `fields` | `fields` | No | string, list; max items: 100 |
| `language` | `language` | No | string; values: en, de, fr, es, pl, tr |
| `limit` | `limit` | No | numeric; min: 1; max: 100 |
| `page_no` | `pageNo` | No | numeric; min: 1 |

## globalmap/seasons

Catalog realms: asia, eu, na.

Instance: `$client->globalMap()->seasons()`

Static: `GlobalMap::seasons()`

Signature: `seasons(array $fields = [], string|null $language = null, int|null $pageNo = null, string|null $seasonId = null, int|null $limit = null, string|null $status = null): array`

Official reference: https://developers.wargaming.net/reference/all/wot/globalmap/seasons/

| WG parameter | Named argument | Required | Type / constraints |
| --- | --- | --- | --- |
| `fields` | `fields` | No | string, list; max items: 100 |
| `language` | `language` | No | string; values: en, de, fr, es, pl, tr |
| `page_no` | `pageNo` | No | numeric; min: 1 |
| `season_id` | `seasonId` | No | string |
| `limit` | `limit` | No | numeric; min: 1; max: 20 |
| `status` | `status` | No | string; values: PLANNED, ACTIVE, FINISHED |

## globalmap/seasonclaninfo

Catalog realms: asia, eu, na.

Instance: `$client->globalMap()->seasonClanInfo(seasonId: 'example', vehicleLevel: ["6"], clanId: 1)`

Static: `GlobalMap::seasonClanInfo(seasonId: 'example', vehicleLevel: ["6"], clanId: 1)`

Signature: `seasonClanInfo(string $seasonId, array $vehicleLevel, int $clanId, array $fields = []): array`

Official reference: https://developers.wargaming.net/reference/all/wot/globalmap/seasonclaninfo/

| WG parameter | Named argument | Required | Type / constraints |
| --- | --- | --- | --- |
| `season_id` | `seasonId` | Yes | string |
| `vehicle_level` | `vehicleLevel` | Yes | string, list; values: 6, 8, 10; max items: 100 |
| `clan_id` | `clanId` | Yes | numeric; min: 1 |
| `fields` | `fields` | No | string, list; max items: 100 |

## globalmap/seasonaccountinfo

Catalog realms: asia, eu, na.

Instance: `$client->globalMap()->seasonAccountInfo(seasonId: 'example', vehicleLevel: ["6"], accountId: 1)`

Static: `GlobalMap::seasonAccountInfo(seasonId: 'example', vehicleLevel: ["6"], accountId: 1)`

Signature: `seasonAccountInfo(string $seasonId, array $vehicleLevel, int $accountId, array $fields = []): array`

Official reference: https://developers.wargaming.net/reference/all/wot/globalmap/seasonaccountinfo/

| WG parameter | Named argument | Required | Type / constraints |
| --- | --- | --- | --- |
| `season_id` | `seasonId` | Yes | string |
| `vehicle_level` | `vehicleLevel` | Yes | string, list; values: 6, 8, 10; max items: 100 |
| `account_id` | `accountId` | Yes | numeric; min: 1 |
| `fields` | `fields` | No | string, list; max items: 100 |

## globalmap/seasonrating

Catalog realms: asia, eu, na.

Instance: `$client->globalMap()->seasonRating(seasonId: 'example', vehicleLevel: '6')`

Static: `GlobalMap::seasonRating(seasonId: 'example', vehicleLevel: '6')`

Signature: `seasonRating(string $seasonId, string $vehicleLevel, array $fields = [], int|null $pageNo = null, int|null $limit = null): array`

Official reference: https://developers.wargaming.net/reference/all/wot/globalmap/seasonrating/

| WG parameter | Named argument | Required | Type / constraints |
| --- | --- | --- | --- |
| `season_id` | `seasonId` | Yes | string |
| `vehicle_level` | `vehicleLevel` | Yes | string; values: 6, 8, 10 |
| `fields` | `fields` | No | string, list; max items: 100 |
| `page_no` | `pageNo` | No | numeric; min: 1 |
| `limit` | `limit` | No | numeric; min: 1; max: 100 |

## globalmap/seasonratingneighbors

Catalog realms: asia, eu, na.

Instance: `$client->globalMap()->seasonRatingNeighbors(seasonId: 'example', vehicleLevel: '6', clanId: 1)`

Static: `GlobalMap::seasonRatingNeighbors(seasonId: 'example', vehicleLevel: '6', clanId: 1)`

Signature: `seasonRatingNeighbors(string $seasonId, string $vehicleLevel, int $clanId, array $fields = [], int|null $limit = null): array`

Official reference: https://developers.wargaming.net/reference/all/wot/globalmap/seasonratingneighbors/

| WG parameter | Named argument | Required | Type / constraints |
| --- | --- | --- | --- |
| `season_id` | `seasonId` | Yes | string |
| `vehicle_level` | `vehicleLevel` | Yes | string; values: 6, 8, 10 |
| `clan_id` | `clanId` | Yes | numeric; min: 1 |
| `fields` | `fields` | No | string, list; max items: 100 |
| `limit` | `limit` | No | numeric; min: 1; max: 99 |

## globalmap/events

Catalog realms: asia, eu, na.

Instance: `$client->globalMap()->events()`

Static: `GlobalMap::events()`

Signature: `events(array $fields = [], string|null $language = null, int|null $pageNo = null, string|null $eventId = null, int|null $limit = null, string|null $status = null): array`

Official reference: https://developers.wargaming.net/reference/all/wot/globalmap/events/

| WG parameter | Named argument | Required | Type / constraints |
| --- | --- | --- | --- |
| `fields` | `fields` | No | string, list; max items: 100 |
| `language` | `language` | No | string; values: en, de, fr, es, pl, tr |
| `page_no` | `pageNo` | No | numeric; min: 1 |
| `event_id` | `eventId` | No | string |
| `limit` | `limit` | No | numeric; min: 1; max: 20 |
| `status` | `status` | No | string; values: PLANNED, ACTIVE, FINISHED |

## globalmap/eventclaninfo

Catalog realms: asia, eu, na.

Instance: `$client->globalMap()->eventClanInfo(eventId: 'example', frontIds: ['example'], clanId: 1)`

Static: `GlobalMap::eventClanInfo(eventId: 'example', frontIds: ['example'], clanId: 1)`

Signature: `eventClanInfo(string $eventId, array $frontIds, int $clanId, array $fields = []): array`

Official reference: https://developers.wargaming.net/reference/all/wot/globalmap/eventclaninfo/

| WG parameter | Named argument | Required | Type / constraints |
| --- | --- | --- | --- |
| `event_id` | `eventId` | Yes | string |
| `front_id` | `frontIds` | Yes | string, list; max items: 10 |
| `clan_id` | `clanId` | Yes | numeric; min: 1 |
| `fields` | `fields` | No | string, list; max items: 100 |

## globalmap/eventaccountinfo

Catalog realms: asia, eu, na.

Instance: `$client->globalMap()->eventAccountInfo(eventId: 'example', frontIds: ['example'], accountId: 1)`

Static: `GlobalMap::eventAccountInfo(eventId: 'example', frontIds: ['example'], accountId: 1)`

Signature: `eventAccountInfo(string $eventId, array $frontIds, int $accountId, array $fields = [], int|null $clanId = null): array`

Official reference: https://developers.wargaming.net/reference/all/wot/globalmap/eventaccountinfo/

| WG parameter | Named argument | Required | Type / constraints |
| --- | --- | --- | --- |
| `event_id` | `eventId` | Yes | string |
| `front_id` | `frontIds` | Yes | string, list; max items: 10 |
| `account_id` | `accountId` | Yes | numeric; min: 1 |
| `fields` | `fields` | No | string, list; max items: 100 |
| `clan_id` | `clanId` | No | numeric; min: 1 |

## globalmap/eventaccountratings

Catalog realms: asia, eu, na.

Instance: `$client->globalMap()->eventAccountRatings(eventId: 'example', frontId: 'example')`

Static: `GlobalMap::eventAccountRatings(eventId: 'example', frontId: 'example')`

Signature: `eventAccountRatings(string $eventId, string $frontId, array $fields = [], int|null $pageNo = null, int|null $limit = null, int|null $inRating = null): array`

Official reference: https://developers.wargaming.net/reference/all/wot/globalmap/eventaccountratings/

| WG parameter | Named argument | Required | Type / constraints |
| --- | --- | --- | --- |
| `event_id` | `eventId` | Yes | string |
| `front_id` | `frontId` | Yes | string |
| `fields` | `fields` | No | string, list; max items: 100 |
| `page_no` | `pageNo` | No | numeric; min: 1 |
| `limit` | `limit` | No | numeric; min: 1; max: 100 |
| `in_rating` | `inRating` | No | numeric; values: 1, 0; min: 0 |

## globalmap/eventaccountratingneighbors

Catalog realms: asia, eu, na.

Instance: `$client->globalMap()->eventAccountRatingNeighbors(eventId: 'example', frontId: 'example', accountId: 1)`

Static: `GlobalMap::eventAccountRatingNeighbors(eventId: 'example', frontId: 'example', accountId: 1)`

Signature: `eventAccountRatingNeighbors(string $eventId, string $frontId, int $accountId, array $fields = [], int|null $pageNo = null, int|null $limit = null, int|null $neighboursCount = null): array`

Official reference: https://developers.wargaming.net/reference/all/wot/globalmap/eventaccountratingneighbors/

| WG parameter | Named argument | Required | Type / constraints |
| --- | --- | --- | --- |
| `event_id` | `eventId` | Yes | string |
| `front_id` | `frontId` | Yes | string |
| `account_id` | `accountId` | Yes | numeric; min: 1 |
| `fields` | `fields` | No | string, list; max items: 100 |
| `page_no` | `pageNo` | No | numeric; min: 1 |
| `limit` | `limit` | No | numeric; min: 1; max: 100 |
| `neighbours_count` | `neighboursCount` | No | numeric; min: 0; max: 99 |

## globalmap/eventrating

Catalog realms: asia, eu, na.

Instance: `$client->globalMap()->eventRating(eventId: 'example', frontId: 'example')`

Static: `GlobalMap::eventRating(eventId: 'example', frontId: 'example')`

Signature: `eventRating(string $eventId, string $frontId, array $fields = [], int|null $pageNo = null, int|null $limit = null): array`

Official reference: https://developers.wargaming.net/reference/all/wot/globalmap/eventrating/

| WG parameter | Named argument | Required | Type / constraints |
| --- | --- | --- | --- |
| `event_id` | `eventId` | Yes | string |
| `front_id` | `frontId` | Yes | string |
| `fields` | `fields` | No | string, list; max items: 100 |
| `page_no` | `pageNo` | No | numeric; min: 1 |
| `limit` | `limit` | No | numeric; min: 1; max: 100 |

## globalmap/eventratingneighbors

Catalog realms: asia, eu, na.

Instance: `$client->globalMap()->eventRatingNeighbors(eventId: 'example', frontId: 'example', clanId: 1)`

Static: `GlobalMap::eventRatingNeighbors(eventId: 'example', frontId: 'example', clanId: 1)`

Signature: `eventRatingNeighbors(string $eventId, string $frontId, int $clanId, array $fields = [], int|null $limit = null): array`

Official reference: https://developers.wargaming.net/reference/all/wot/globalmap/eventratingneighbors/

| WG parameter | Named argument | Required | Type / constraints |
| --- | --- | --- | --- |
| `event_id` | `eventId` | Yes | string |
| `front_id` | `frontId` | Yes | string |
| `clan_id` | `clanId` | Yes | numeric; min: 1 |
| `fields` | `fields` | No | string, list; max items: 100 |
| `limit` | `limit` | No | numeric; min: 1; max: 99 |

## globalmap/info

Catalog realms: asia, eu, na.

Instance: `$client->globalMap()->info()`

Static: `GlobalMap::info()`

Signature: `info(array $fields = []): array`

Official reference: https://developers.wargaming.net/reference/all/wot/globalmap/info/

| WG parameter | Named argument | Required | Type / constraints |
| --- | --- | --- | --- |
| `fields` | `fields` | No | string, list; max items: 100 |

## stronghold/claninfo

Catalog realms: asia, eu, na.

Instance: `$client->stronghold()->clanInfo(clanIds: [500000001], batchSize: 25)`

Static: `Stronghold::clanInfo(clanIds: [500000001], batchSize: 25)`

Signature: `clanInfo(array $clanIds, int $batchSize, array $fields = [], string|null $language = null): array`

Official reference: https://developers.wargaming.net/reference/all/wot/stronghold/claninfo/

| WG parameter | Named argument | Required | Type / constraints |
| --- | --- | --- | --- |
| `clan_id` | `clanIds` | Yes | numeric, list; min: 1; WG list limit (caller chooses K): 10 |
| `fields` | `fields` | No | string, list; max items: 100 |
| `language` | `language` | No | string; values: en, de, pl, fr, es, cs, tr |
| Client grouping | `batchSize` | Yes | Positive integer K, chosen by caller. |

## stronghold/clanreserves

Catalog realms: asia, eu, na.

Instance: `$client->stronghold()->clanReserves(accessToken: 'example')`

Static: `Stronghold::clanReserves(accessToken: 'example')`

Signature: `clanReserves(#[SensitiveParameter] string $accessToken, array $fields = [], string|null $language = null): array`

Official reference: https://developers.wargaming.net/reference/all/wot/stronghold/clanreserves/

| WG parameter | Named argument | Required | Type / constraints |
| --- | --- | --- | --- |
| `access_token` | `accessToken` | Yes | string |
| `fields` | `fields` | No | string, list; max items: 100 |
| `language` | `language` | No | string; values: en, de, pl, fr, es, cs, tr |

## ratings/types

Catalog realms: asia, eu, na.

**Deprecated:** marked deprecated in the WG catalog. This method remains callable and returns raw HTTP results.

Instance: `$client->ratings()->types()`

Static: `Ratings::types()`

Signature: `types(string|null $language = null, array $fields = [], string|null $battleType = null): array`

Official reference: https://developers.wargaming.net/reference/all/wot/ratings/types/

| WG parameter | Named argument | Required | Type / constraints |
| --- | --- | --- | --- |
| `language` | `language` | No | string; values: en, ru, pl, de, fr, es, zh-cn, zh-tw, tr, cs, th, vi, ko |
| `fields` | `fields` | No | string, list; max items: 100 |
| `battle_type` | `battleType` | No | string; values: company, random, team, default |

## ratings/dates

Catalog realms: asia, eu, na.

**Deprecated:** marked deprecated in the WG catalog. This method remains callable and returns raw HTTP results.

Instance: `$client->ratings()->dates(type: 'example')`

Static: `Ratings::dates(type: 'example')`

Signature: `dates(string $type, string|null $language = null, array $fields = [], string|null $battleType = null, array $accountIds = []): array`

Official reference: https://developers.wargaming.net/reference/all/wot/ratings/dates/

| WG parameter | Named argument | Required | Type / constraints |
| --- | --- | --- | --- |
| `type` | `type` | Yes | string |
| `language` | `language` | No | string; values: en, ru, pl, de, fr, es, zh-cn, zh-tw, tr, cs, th, vi, ko |
| `fields` | `fields` | No | string, list; max items: 100 |
| `battle_type` | `battleType` | No | string; values: company, random, team, default |
| `account_id` | `accountIds` | No | numeric, list; min: 1; max items: 100 |

## ratings/accounts

Catalog realms: asia, eu, na.

**Deprecated:** marked deprecated in the WG catalog. This method remains callable and returns raw HTTP results.

Instance: `$client->ratings()->accounts(type: 'example', accountIds: [500000001], batchSize: 25)`

Static: `Ratings::accounts(type: 'example', accountIds: [500000001], batchSize: 25)`

Signature: `accounts(string $type, array $accountIds, int $batchSize, string|null $language = null, array $fields = [], string|null $battleType = null, int|string|null $date = null): array`

Official reference: https://developers.wargaming.net/reference/all/wot/ratings/accounts/

| WG parameter | Named argument | Required | Type / constraints |
| --- | --- | --- | --- |
| `type` | `type` | Yes | string |
| `account_id` | `accountIds` | Yes | numeric, list; min: 1; WG list limit (caller chooses K): 100 |
| `language` | `language` | No | string; values: en, ru, pl, de, fr, es, zh-cn, zh-tw, tr, cs, th, vi, ko |
| `fields` | `fields` | No | string, list; max items: 100 |
| `battle_type` | `battleType` | No | string; values: company, random, team, default |
| `date` | `date` | No | timestamp/date |
| Client grouping | `batchSize` | Yes | Positive integer K, chosen by caller. |

## ratings/neighbors

Catalog realms: asia, eu, na.

**Deprecated:** marked deprecated in the WG catalog. This method remains callable and returns raw HTTP results.

Instance: `$client->ratings()->neighbors(type: 'example', accountId: 1, rankField: 'example')`

Static: `Ratings::neighbors(type: 'example', accountId: 1, rankField: 'example')`

Signature: `neighbors(string $type, int $accountId, string $rankField, string|null $language = null, array $fields = [], string|null $battleType = null, int|string|null $date = null, int|null $limit = null): array`

Official reference: https://developers.wargaming.net/reference/all/wot/ratings/neighbors/

| WG parameter | Named argument | Required | Type / constraints |
| --- | --- | --- | --- |
| `type` | `type` | Yes | string |
| `account_id` | `accountId` | Yes | numeric; min: 1 |
| `rank_field` | `rankField` | Yes | string |
| `language` | `language` | No | string; values: en, ru, pl, de, fr, es, zh-cn, zh-tw, tr, cs, th, vi, ko |
| `fields` | `fields` | No | string, list; max items: 100 |
| `battle_type` | `battleType` | No | string; values: company, random, team, default |
| `date` | `date` | No | timestamp/date |
| `limit` | `limit` | No | numeric; min: 1; max: 50 |

## ratings/top

Catalog realms: asia, eu, na.

**Deprecated:** marked deprecated in the WG catalog. This method remains callable and returns raw HTTP results.

Instance: `$client->ratings()->top(type: 'example', rankField: 'example')`

Static: `Ratings::top(type: 'example', rankField: 'example')`

Signature: `top(string $type, string $rankField, string|null $language = null, array $fields = [], string|null $battleType = null, int|string|null $date = null, int|null $limit = null, int|null $pageNo = null): array`

Official reference: https://developers.wargaming.net/reference/all/wot/ratings/top/

| WG parameter | Named argument | Required | Type / constraints |
| --- | --- | --- | --- |
| `type` | `type` | Yes | string |
| `rank_field` | `rankField` | Yes | string |
| `language` | `language` | No | string; values: en, ru, pl, de, fr, es, zh-cn, zh-tw, tr, cs, th, vi, ko |
| `fields` | `fields` | No | string, list; max items: 100 |
| `battle_type` | `battleType` | No | string; values: company, random, team, default |
| `date` | `date` | No | timestamp/date |
| `limit` | `limit` | No | numeric; min: 1; max: 1000 |
| `page_no` | `pageNo` | No | numeric; min: 1 |
