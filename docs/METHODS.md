# Complete WoT method reference

API version/namespace: **`wot`**, URL prefix **`/wot/`**. Contract reviewed **2026-09-27**. SDK documentation: **1.0.1**.

All 68 catalog methods are covered: 65 data/operation methods and three WgAuth methods. Each entry includes all SDK arguments, the mapped API parameters, return shape, instance and static examples. Pagination helpers are included where supported.

## Example setup and conventions

Run the setup once in your application. Code blocks below are independent alternatives: choose the instance or static call. Do not run every block as a script.

```php
require __DIR__.'/vendor/autoload.php';

use edrard\WgApi\Realm;
use edrard\WotClient\WotClient;
use edrard\WotClient\Facades\{Accounts, Tanks, Encyclopedia, Clans, ClanRatings, GlobalMap, Stronghold, Ratings, Auth, Wot};

$applicationId = getenv('WG_APPLICATION_ID') ?: throw new LogicException('Configure WG_APPLICATION_ID.');
$client = new WotClient($applicationId, realm: Realm::EU);
Wot::configure($client);
```

Supply `$accountId`, `$clanId` and `$tankId` as positive integers obtained from the corresponding search/catalog in the same realm. `$frontId`, `$eventId`, `$seasonId` and `$rankField` come from fronts/events/seasons/types responses; do not assume a particular season or ranking is currently available. `$ratingType` comes from ratings/types (deprecated). `$token` is the AccessToken from a verified WgAuth login, not a raw callback string. `$reserveType` and positive integer `$reserveLevel` come from clanReserves(). `$callbackUri` is your trusted HTTPS callback URL.

`application_id` is configured on WotClient, not passed into each method. Optional `null`/empty-array arguments are omitted from the provider request; WG chooses omitted defaults except language, which defaults to the client language. Numeric lists contain integers. String lists contain strings. See the per-method official link for provider field descriptions and evolving defaults.

All data methods return ApiResult. `data()` preserves provider keys, lists, nulls and selected fields; `meta` retains metadata. `record($key)` reads a collection row, `get($key)` reads a nested list, `object()` reads a single object. Fields listed below are available top-level selectors, not guaranteed required keys: selecting fields may omit others. Nested selectors and their field types are in the [reviewed schema](../resources/endpoints.json) and each official reference.

For deprecated examples, explicitly create `$legacyClient = new WotClient($applicationId, realm: Realm::EU, allowDeprecated: true);`. Configure `Wot::configure($legacyClient)` before their static alternatives; restore `Wot::configure($client)` afterwards. Provider availability is not guaranteed. Call `Wot::reset()` at the end of an independent job.

## Index

- [Accounts](#accounts)
- [Tanks](#tanks)
- [Encyclopedia](#encyclopedia)
- [Clans](#clans)
- [ClanRatings](#clanratings)
- [GlobalMap](#globalmap)
- [Stronghold](#stronghold)
- [Ratings](#ratings)
- [Authentication](#authentication)

## accounts

### account/list

Search player accounts by nickname.

[Official reference](https://developers.wargaming.net/reference/all/wot/account/list/). Realms: asia, eu, na.

Signature (identical on service and static facade):

```php
Accounts::search(
    string $search,
    string|null $language = null,
    array $fields = [],
    string|null $type = null,
    int|null $limit = null,
): ApiResult;
```

| SDK argument / API parameter | Meaning | Required / SDK default | Contract constraints |
| --- | --- | --- | --- |
| `$search` / `search` | Nickname, clan name or clan tag search text, depending on the method. Provider type: `string`. | Required | No further bound in the reviewed contract. |
| `$language` / `language` | Response language; omission uses the client's configured language. Provider type: `string`. | Optional / `null` | values: `en`, `ru`, `pl`, `de`, `fr`, `es`, `zh-cn`, `zh-tw`, `tr`, `cs`, `th`, `vi`, `ko` |
| `$fields` / `fields` | Response field selectors; dot paths include nested fields, a leading minus excludes fields. Provider type: `string, list`. | Optional / `[]` | items/request: 100 |
| `$type` / `type` | Search mode, catalog category or rating type, depending on this endpoint. Provider type: `string`. | Optional / `null` | minimum length: 3; maximum length: 24; values: `startswith`, `exact` |
| `$limit` / `limit` | Maximum number of rows requested per page or response. Provider type: `numeric`. | Optional / `null` | maximum: 100 |

**Result:** ApiResult. Collection/map of records using WG's original keys; use `$result->record($key)` or `$result->data()`.

Top-level response fields: `account_id` (numeric), `nickname` (string).

Multiget: `prepareSearch()` accepts identical arguments and returns PreparedOperation without network I/O. Submit it to `executeMany()`. A paginated preparation represents one page.

<!-- example:account/list -->
```php
// Instance call
$result = $client->accounts()->search(
    search: 'Player',
    limit: 10,
);
$data = $result->data();

// Static alternative; configure the corresponding client first.
$result = Accounts::search(
    search: 'Player',
    limit: 10,
);
$data = $result->data();

// Prepare for multiget; instance and static alternatives (no I/O).
$operation = $client->accounts()->prepareSearch(
    search: 'Player',
    limit: 10,
);
$operation = Accounts::prepareSearch(
    search: 'Player',
    limit: 10,
);
```

### account/info

Read account profiles, aggregate statistics and authorized private fields.

[Official reference](https://developers.wargaming.net/reference/all/wot/account/info/). Realms: asia, eu, na.

Signature (identical on service and static facade):

```php
Accounts::info(
    array $accountIds,
    string|null $language = null,
    array $fields = [],
    AccessToken|null $accessToken = null,
    array $extra = [],
): ApiResult;
```

| SDK argument / API parameter | Meaning | Required / SDK default | Contract constraints |
| --- | --- | --- | --- |
| `$accountIds` / `account_id` | Absolute player account ID(s) in the selected realm. Provider type: `numeric, list`. | Required | items/request: 100 Required IDs are deduplicated and automatically batched at this limit. |
| `$language` / `language` | Response language; omission uses the client's configured language. Provider type: `string`. | Optional / `null` | values: `en`, `ru`, `pl`, `de`, `fr`, `es`, `zh-cn`, `zh-tw`, `tr`, `cs`, `th`, `vi`, `ko` |
| `$fields` / `fields` | Response field selectors; dot paths include nested fields, a leading minus excludes fields. Provider type: `string, list`. | Optional / `[]` | items/request: 100 |
| `$accessToken` / `access_token` | Verified, unexpired WgAuth token for the selected realm. Provider type: `string`. | Optional / `null` | No further bound in the reviewed contract. |
| `$extra` / `extra` | Additional response fields; only the listed selectors are supported. Provider type: `string, list`. | Optional / `[]` | values: `private.boosters`, `private.garage`, `private.grouped_contacts`, `private.personal_missions`, `private.rented`, `statistics.epic`, `statistics.fallout`, `statistics.globalmap_absolute`, `statistics.globalmap_champion`, `statistics.globalmap_middle`, `statistics.random`, `statistics.ranked_10x10`, `statistics.ranked_15x15`, `statistics.ranked_battles`, `statistics.ranked_battles_current`, `statistics.ranked_battles_previous`, `statistics.ranked_season_1`, `statistics.ranked_season_2`, `statistics.ranked_season_3` |

**Result:** ApiResult. Collection/map of records using WG's original keys; use `$result->record($key)` or `$result->data()`.

Top-level response fields: `account_id` (numeric), `clan_id` (numeric), `client_language` (string), `created_at` (timestamp), `global_rating` (numeric), `last_battle_time` (timestamp), `logout_at` (timestamp), `nickname` (string), `private` (block_header), `statistics` (block_header), `updated_at` (timestamp).

Multiget: `prepareInfo()` accepts identical arguments and returns PreparedOperation without network I/O. Submit it to `executeMany()`. A paginated preparation represents one page.

<!-- example:account/info -->
```php
// Instance call
$result = $client->accounts()->info(
    accountIds: [$accountId],
);
$data = $result->data();

// Static alternative; configure the corresponding client first.
$result = Accounts::info(
    accountIds: [$accountId],
);
$data = $result->data();

// Prepare for multiget; instance and static alternatives (no I/O).
$operation = $client->accounts()->prepareInfo(
    accountIds: [$accountId],
);
$operation = Accounts::prepareInfo(
    accountIds: [$accountId],
);
```

### account/tanks

Read the vehicles associated with each account and their summary statistics.

[Official reference](https://developers.wargaming.net/reference/all/wot/account/tanks/). Realms: asia, eu, na.

Signature (identical on service and static facade):

```php
Accounts::tanks(
    array $accountIds,
    string|null $language = null,
    array $fields = [],
    AccessToken|null $accessToken = null,
    array $tankIds = [],
): ApiResult;
```

| SDK argument / API parameter | Meaning | Required / SDK default | Contract constraints |
| --- | --- | --- | --- |
| `$accountIds` / `account_id` | Absolute player account ID(s) in the selected realm. Provider type: `numeric, list`. | Required | items/request: 100 Required IDs are deduplicated and automatically batched at this limit. |
| `$language` / `language` | Response language; omission uses the client's configured language. Provider type: `string`. | Optional / `null` | values: `en`, `ru`, `pl`, `de`, `fr`, `es`, `zh-cn`, `zh-tw`, `tr`, `cs`, `th`, `vi`, `ko` |
| `$fields` / `fields` | Response field selectors; dot paths include nested fields, a leading minus excludes fields. Provider type: `string, list`. | Optional / `[]` | items/request: 100 |
| `$accessToken` / `access_token` | Verified, unexpired WgAuth token for the selected realm. Provider type: `string`. | Optional / `null` | No further bound in the reviewed contract. |
| `$tankIds` / `tank_id` | Vehicle ID(s) from encyclopedia/vehicles. Provider type: `numeric, list`. | Optional / `[]` | items/request: 100 |

**Result:** ApiResult. Map containing nested lists (often keyed by account/clan ID); use `$result->get($key)` or `$result->data()`.

Top-level response fields: `mark_of_mastery` (numeric), `statistics` (block_header), `tank_id` (numeric).

Multiget: `prepareTanks()` accepts identical arguments and returns PreparedOperation without network I/O. Submit it to `executeMany()`. A paginated preparation represents one page.

<!-- example:account/tanks -->
```php
// Instance call
$result = $client->accounts()->tanks(
    accountIds: [$accountId],
);
$data = $result->data();

// Static alternative; configure the corresponding client first.
$result = Accounts::tanks(
    accountIds: [$accountId],
);
$data = $result->data();

// Prepare for multiget; instance and static alternatives (no I/O).
$operation = $client->accounts()->prepareTanks(
    accountIds: [$accountId],
);
$operation = Accounts::prepareTanks(
    accountIds: [$accountId],
);
```

### account/achievements

Read account achievement counters.

[Official reference](https://developers.wargaming.net/reference/all/wot/account/achievements/). Realms: asia, eu, na.

Signature (identical on service and static facade):

```php
Accounts::achievements(
    array $accountIds,
    string|null $language = null,
    array $fields = [],
): ApiResult;
```

| SDK argument / API parameter | Meaning | Required / SDK default | Contract constraints |
| --- | --- | --- | --- |
| `$accountIds` / `account_id` | Absolute player account ID(s) in the selected realm. Provider type: `numeric, list`. | Required | items/request: 100 Required IDs are deduplicated and automatically batched at this limit. |
| `$language` / `language` | Response language; omission uses the client's configured language. Provider type: `string`. | Optional / `null` | values: `en`, `ru`, `pl`, `de`, `fr`, `es`, `zh-cn`, `zh-tw`, `tr`, `cs`, `th`, `vi`, `ko` |
| `$fields` / `fields` | Response field selectors; dot paths include nested fields, a leading minus excludes fields. Provider type: `string, list`. | Optional / `[]` | items/request: 100 |

**Result:** ApiResult. Collection/map of records using WG's original keys; use `$result->record($key)` or `$result->data()`.

Top-level response fields: `achievements` (associative array), `frags` (associative array), `max_series` (associative array).

Multiget: `prepareAchievements()` accepts identical arguments and returns PreparedOperation without network I/O. Submit it to `executeMany()`. A paginated preparation represents one page.

<!-- example:account/achievements -->
```php
// Instance call
$result = $client->accounts()->achievements(
    accountIds: [$accountId],
);
$data = $result->data();

// Static alternative; configure the corresponding client first.
$result = Accounts::achievements(
    accountIds: [$accountId],
);
$data = $result->data();

// Prepare for multiget; instance and static alternatives (no I/O).
$operation = $client->accounts()->prepareAchievements(
    accountIds: [$accountId],
);
$operation = Accounts::prepareAchievements(
    accountIds: [$accountId],
);
```

### account/wtr

Read account World of Tanks Rating statistics.

[Official reference](https://developers.wargaming.net/reference/all/wot/account/wtr/). Realms: asia, eu, na.

Signature (identical on service and static facade):

```php
Accounts::wtr(
    array $accountIds,
    string|null $language = null,
    array $fields = [],
): ApiResult;
```

| SDK argument / API parameter | Meaning | Required / SDK default | Contract constraints |
| --- | --- | --- | --- |
| `$accountIds` / `account_id` | Absolute player account ID(s) in the selected realm. Provider type: `numeric, list`. | Required | items/request: 100 Required IDs are deduplicated and automatically batched at this limit. |
| `$language` / `language` | Response language; omission uses the client's configured language. Provider type: `string`. | Optional / `null` | values: `en`, `ru`, `pl`, `de`, `fr`, `es`, `zh-cn`, `zh-tw`, `tr`, `cs`, `th`, `vi`, `ko` |
| `$fields` / `fields` | Response field selectors; dot paths include nested fields, a leading minus excludes fields. Provider type: `string, list`. | Optional / `[]` | items/request: 100 |

**Result:** ApiResult. Collection/map of records using WG's original keys; use `$result->record($key)` or `$result->data()`.

Top-level response fields: `account_id` (numeric), `rating` (numeric).

Multiget: `prepareWtr()` accepts identical arguments and returns PreparedOperation without network I/O. Submit it to `executeMany()`. A paginated preparation represents one page.

<!-- example:account/wtr -->
```php
// Instance call
$result = $client->accounts()->wtr(
    accountIds: [$accountId],
);
$data = $result->data();

// Static alternative; configure the corresponding client first.
$result = Accounts::wtr(
    accountIds: [$accountId],
);
$data = $result->data();

// Prepare for multiget; instance and static alternatives (no I/O).
$operation = $client->accounts()->prepareWtr(
    accountIds: [$accountId],
);
$operation = Accounts::prepareWtr(
    accountIds: [$accountId],
);
```

## tanks

### tanks/stats

Read an account's detailed statistics for selected vehicles.

[Official reference](https://developers.wargaming.net/reference/all/wot/tanks/stats/). Realms: asia, eu, na.

Signature (identical on service and static facade):

```php
Tanks::stats(
    int $accountId,
    string|null $language = null,
    array $fields = [],
    AccessToken|null $accessToken = null,
    array $extra = [],
    array $tankIds = [],
    string|null $inGarage = null,
): ApiResult;
```

| SDK argument / API parameter | Meaning | Required / SDK default | Contract constraints |
| --- | --- | --- | --- |
| `$accountId` / `account_id` | Absolute player account ID(s) in the selected realm. Provider type: `numeric`. | Required | No further bound in the reviewed contract. |
| `$language` / `language` | Response language; omission uses the client's configured language. Provider type: `string`. | Optional / `null` | values: `en`, `ru`, `pl`, `de`, `fr`, `es`, `zh-cn`, `zh-tw`, `tr`, `cs`, `th`, `vi`, `ko` |
| `$fields` / `fields` | Response field selectors; dot paths include nested fields, a leading minus excludes fields. Provider type: `string, list`. | Optional / `[]` | items/request: 100 |
| `$accessToken` / `access_token` | Verified, unexpired WgAuth token for the selected realm. Provider type: `string`. | Optional / `null` | No further bound in the reviewed contract. |
| `$extra` / `extra` | Additional response fields; only the listed selectors are supported. Provider type: `string, list`. | Optional / `[]` | values: `epic`, `fallout`, `random`, `ranked_10x10`, `ranked_battles` |
| `$tankIds` / `tank_id` | Vehicle ID(s) from encyclopedia/vehicles. Provider type: `numeric, list`. | Optional / `[]` | items/request: 100 |
| `$inGarage` / `in_garage` | Garage filter; requires a matching accessToken. Provider type: `string`. | Optional / `null` | values: `1`, `0` |

**Result:** ApiResult. Map containing nested lists (often keyed by account/clan ID); use `$result->get($key)` or `$result->data()`.

Top-level response fields: `account_id` (numeric), `all` (block_header), `clan` (block_header), `company` (block_header), `epic` (block_header), `fallout` (block_header), `frags` (associative array), `globalmap` (block_header), `in_garage` (boolean), `mark_of_mastery` (numeric), `max_frags` (numeric), `max_xp` (numeric), `random` (block_header), `ranked_10x10` (block_header), `ranked_battles` (block_header), `regular_team` (block_header), `stronghold_defense` (block_header), `stronghold_skirmish` (block_header), `tank_id` (numeric), `team` (block_header).

Multiget: `prepareStats()` accepts identical arguments and returns PreparedOperation without network I/O. Submit it to `executeMany()`. A paginated preparation represents one page.

<!-- example:tanks/stats -->
```php
// Instance call
$result = $client->tanks()->stats(
    accountId: $accountId,
);
$data = $result->data();

// Static alternative; configure the corresponding client first.
$result = Tanks::stats(
    accountId: $accountId,
);
$data = $result->data();

// Prepare for multiget; instance and static alternatives (no I/O).
$operation = $client->tanks()->prepareStats(
    accountId: $accountId,
);
$operation = Tanks::prepareStats(
    accountId: $accountId,
);
```

### tanks/achievements

Read an account's achievement counters for selected vehicles.

[Official reference](https://developers.wargaming.net/reference/all/wot/tanks/achievements/). Realms: asia, eu, na.

Signature (identical on service and static facade):

```php
Tanks::achievements(
    int $accountId,
    string|null $language = null,
    array $fields = [],
    AccessToken|null $accessToken = null,
    array $tankIds = [],
    string|null $inGarage = null,
): ApiResult;
```

| SDK argument / API parameter | Meaning | Required / SDK default | Contract constraints |
| --- | --- | --- | --- |
| `$accountId` / `account_id` | Absolute player account ID(s) in the selected realm. Provider type: `numeric`. | Required | No further bound in the reviewed contract. |
| `$language` / `language` | Response language; omission uses the client's configured language. Provider type: `string`. | Optional / `null` | values: `en`, `ru`, `pl`, `de`, `fr`, `es`, `zh-cn`, `zh-tw`, `tr`, `cs`, `th`, `vi`, `ko` |
| `$fields` / `fields` | Response field selectors; dot paths include nested fields, a leading minus excludes fields. Provider type: `string, list`. | Optional / `[]` | items/request: 100 |
| `$accessToken` / `access_token` | Verified, unexpired WgAuth token for the selected realm. Provider type: `string`. | Optional / `null` | No further bound in the reviewed contract. |
| `$tankIds` / `tank_id` | Vehicle ID(s) from encyclopedia/vehicles. Provider type: `numeric, list`. | Optional / `[]` | items/request: 100 |
| `$inGarage` / `in_garage` | Garage filter; requires a matching accessToken. Provider type: `string`. | Optional / `null` | values: `1`, `0` |

**Result:** ApiResult. Map containing nested lists (often keyed by account/clan ID); use `$result->get($key)` or `$result->data()`.

Top-level response fields: `account_id` (numeric), `achievements` (associative array), `max_series` (associative array), `series` (associative array), `tank_id` (numeric).

Multiget: `prepareAchievements()` accepts identical arguments and returns PreparedOperation without network I/O. Submit it to `executeMany()`. A paginated preparation represents one page.

<!-- example:tanks/achievements -->
```php
// Instance call
$result = $client->tanks()->achievements(
    accountId: $accountId,
);
$data = $result->data();

// Static alternative; configure the corresponding client first.
$result = Tanks::achievements(
    accountId: $accountId,
);
$data = $result->data();

// Prepare for multiget; instance and static alternatives (no I/O).
$operation = $client->tanks()->prepareAchievements(
    accountId: $accountId,
);
$operation = Tanks::prepareAchievements(
    accountId: $accountId,
);
```

### tanks/mastery

Read vehicle mastery thresholds for the requested distribution and percentiles.

[Official reference](https://developers.wargaming.net/reference/all/wot/tanks/mastery/). Realms: asia, eu, na.

Signature (identical on service and static facade):

```php
Tanks::mastery(
    string $distribution,
    array $percentile,
    string|null $language = null,
    array $fields = [],
    array $tankIds = [],
): ApiResult;
```

| SDK argument / API parameter | Meaning | Required / SDK default | Contract constraints |
| --- | --- | --- | --- |
| `$distribution` / `distribution` | Distribution used to calculate mastery thresholds. Provider type: `string`. | Required | values: `damage`, `xp` |
| `$percentile` / `percentile` | Percentile positions for the mastery distribution. Provider type: `numeric, list`. | Required | maximum: 100; items/request: 10 |
| `$language` / `language` | Response language; omission uses the client's configured language. Provider type: `string`. | Optional / `null` | values: `en`, `ru`, `pl`, `de`, `fr`, `es`, `zh-cn`, `zh-tw`, `tr`, `cs`, `th`, `vi`, `ko` |
| `$fields` / `fields` | Response field selectors; dot paths include nested fields, a leading minus excludes fields. Provider type: `string, list`. | Optional / `[]` | items/request: 100 |
| `$tankIds` / `tank_id` | Vehicle ID(s) from encyclopedia/vehicles. Provider type: `numeric, list`. | Optional / `[]` | items/request: 100 |

**Result:** ApiResult. Collection/map of records using WG's original keys; use `$result->record($key)` or `$result->data()`.

Top-level response fields: `distribution` (associative array), `updated_at` (timestamp).

Multiget: `prepareMastery()` accepts identical arguments and returns PreparedOperation without network I/O. Submit it to `executeMany()`. A paginated preparation represents one page.

<!-- example:tanks/mastery -->
```php
// Instance call
$result = $client->tanks()->mastery(
    distribution: 'xp',
    percentile: [50, 90],
);
$data = $result->data();

// Static alternative; configure the corresponding client first.
$result = Tanks::mastery(
    distribution: 'xp',
    percentile: [50, 90],
);
$data = $result->data();

// Prepare for multiget; instance and static alternatives (no I/O).
$operation = $client->tanks()->prepareMastery(
    distribution: 'xp',
    percentile: [50, 90],
);
$operation = Tanks::prepareMastery(
    distribution: 'xp',
    percentile: [50, 90],
);
```

## encyclopedia

### encyclopedia/tanks

Read the deprecated vehicle catalog; prefer vehicles().

[Official reference](https://developers.wargaming.net/reference/all/wot/encyclopedia/tanks/). Realms: asia, eu, na.

**Deprecated:** use the explicit legacy client described above.

Signature (identical on service and static facade):

```php
Encyclopedia::tanks(
    string|null $language = null,
    array $fields = [],
): ApiResult;
```

| SDK argument / API parameter | Meaning | Required / SDK default | Contract constraints |
| --- | --- | --- | --- |
| `$language` / `language` | Response language; omission uses the client's configured language. Provider type: `string`. | Optional / `null` | values: `en`, `ru`, `pl`, `de`, `fr`, `es`, `zh-cn`, `zh-tw`, `tr`, `cs`, `th`, `vi`, `ko` |
| `$fields` / `fields` | Response field selectors; dot paths include nested fields, a leading minus excludes fields. Provider type: `string, list`. | Optional / `[]` | items/request: 100 |

**Result:** ApiResult. Collection/map of records using WG's original keys; use `$result->record($key)` or `$result->data()`.

Top-level response fields: `contour_image` (string), `image` (string), `image_small` (string), `is_premium` (boolean), `level` (numeric), `name` (string), `name_i18n` (string), `nation` (string), `nation_i18n` (string), `short_name_i18n` (string), `tank_id` (numeric), `type` (string), `type_i18n` (string).

Multiget: `prepareTanks()` accepts identical arguments and returns PreparedOperation without network I/O. Submit it to `executeMany()`. A paginated preparation represents one page.

<!-- example:encyclopedia/tanks -->
```php
// Instance call
$result = $legacyClient->encyclopedia()->tanks();
$data = $result->data();

// Static alternative; configure the corresponding client first.
$result = Encyclopedia::tanks();
$data = $result->data();

// Prepare for multiget; instance and static alternatives (no I/O).
$operation = $legacyClient->encyclopedia()->prepareTanks();
$operation = Encyclopedia::prepareTanks();
```

### encyclopedia/tankinfo

Read deprecated vehicle details; prefer vehicles() or vehicleProfile().

[Official reference](https://developers.wargaming.net/reference/all/wot/encyclopedia/tankinfo/). Realms: asia, eu, na.

**Deprecated:** use the explicit legacy client described above.

Signature (identical on service and static facade):

```php
Encyclopedia::tankInfo(
    array $tankIds,
    string|null $language = null,
    array $fields = [],
): ApiResult;
```

| SDK argument / API parameter | Meaning | Required / SDK default | Contract constraints |
| --- | --- | --- | --- |
| `$tankIds` / `tank_id` | Vehicle ID(s) from encyclopedia/vehicles. Provider type: `numeric, list`. | Required | items/request: 1000 Required IDs are deduplicated and automatically batched at this limit. |
| `$language` / `language` | Response language; omission uses the client's configured language. Provider type: `string`. | Optional / `null` | values: `en`, `ru`, `pl`, `de`, `fr`, `es`, `zh-cn`, `zh-tw`, `tr`, `cs`, `th`, `vi`, `ko` |
| `$fields` / `fields` | Response field selectors; dot paths include nested fields, a leading minus excludes fields. Provider type: `string, list`. | Optional / `[]` | items/request: 100 |

**Result:** ApiResult. Collection/map of records using WG's original keys; use `$result->record($key)` or `$result->data()`.

Top-level response fields: `chassis` (block_header), `chassis_rotation_speed` (numeric), `circular_vision_radius` (numeric), `contour_image` (string), `crew` (block_header), `engine_power` (numeric), `engines` (block_header), `gun_damage_max` (numeric), `gun_damage_min` (numeric), `gun_max_ammo` (numeric), `gun_name` (string), `gun_piercing_power_max` (numeric), `gun_piercing_power_min` (numeric), `gun_rate` (float), `guns` (block_header), `image` (string), `image_small` (string), `is_gift` (boolean), `is_premium` (boolean), `level` (numeric), `limit_weight` (float), `localized_name` (string), `max_health` (numeric), `name` (string), `name_i18n` (string), `nation` (string), `nation_i18n` (string), `parent_tanks` (list of integers), `price_credit` (numeric), `price_gold` (numeric), `price_xp` (numeric), `radio_distance` (numeric), `radios` (block_header), `short_name_i18n` (string), `speed_limit` (float), `tank_id` (numeric), `turret_armor_board` (numeric), `turret_armor_fedd` (numeric), `turret_armor_forehead` (numeric), `turret_rotation_speed` (numeric), `turrets` (block_header), `type` (string), `type_i18n` (string), `vehicle_armor_board` (numeric), `vehicle_armor_fedd` (numeric), `vehicle_armor_forehead` (numeric), `weight` (float).

Multiget: `prepareTankInfo()` accepts identical arguments and returns PreparedOperation without network I/O. Submit it to `executeMany()`. A paginated preparation represents one page.

<!-- example:encyclopedia/tankinfo -->
```php
// Instance call
$result = $legacyClient->encyclopedia()->tankInfo(
    tankIds: [$tankId],
);
$data = $result->data();

// Static alternative; configure the corresponding client first.
$result = Encyclopedia::tankInfo(
    tankIds: [$tankId],
);
$data = $result->data();

// Prepare for multiget; instance and static alternatives (no I/O).
$operation = $legacyClient->encyclopedia()->prepareTankInfo(
    tankIds: [$tankId],
);
$operation = Encyclopedia::prepareTankInfo(
    tankIds: [$tankId],
);
```

### encyclopedia/vehicles

Read the vehicle catalog, including characteristics and default configurations.

[Official reference](https://developers.wargaming.net/reference/all/wot/encyclopedia/vehicles/). Realms: asia, eu, na.

Signature (identical on service and static facade):

```php
Encyclopedia::vehicles(
    array $fields = [],
    string|null $language = null,
    int|null $pageNo = null,
    int|null $limit = null,
    array $tankIds = [],
    array $nation = [],
    array $type = [],
    array $tier = [],
): ApiResult;
```

| SDK argument / API parameter | Meaning | Required / SDK default | Contract constraints |
| --- | --- | --- | --- |
| `$fields` / `fields` | Response field selectors; dot paths include nested fields, a leading minus excludes fields. Provider type: `string, list`. | Optional / `[]` | items/request: 100 |
| `$language` / `language` | Response language; omission uses the client's configured language. Provider type: `string`. | Optional / `null` | values: `en`, `ru`, `pl`, `de`, `fr`, `es`, `zh-cn`, `zh-tw`, `tr`, `cs`, `th`, `vi`, `ko` |
| `$pageNo` / `page_no` | One-based page number; use iterate/all helpers to traverse pages. Provider type: `numeric`. | Optional / `null` | No further bound in the reviewed contract. |
| `$limit` / `limit` | Maximum number of rows requested per page or response. Provider type: `numeric`. | Optional / `null` | maximum: 100 |
| `$tankIds` / `tank_id` | Vehicle ID(s) from encyclopedia/vehicles. Provider type: `numeric, list`. | Optional / `[]` | items/request: 100 |
| `$nation` / `nation` | Vehicle/module nation filter. Provider type: `string, list`. | Optional / `[]` | items/request: 100 |
| `$type` / `type` | Search mode, catalog category or rating type, depending on this endpoint. Provider type: `string, list`. | Optional / `[]` | items/request: 100; values: `heavyTank`, `AT-SPG`, `mediumTank`, `lightTank`, `SPG` |
| `$tier` / `tier` | Vehicle or module tier filter. Provider type: `numeric, list`. | Optional / `[]` | items/request: 100 |

**Result:** ApiResult. Collection/map of records using WG's original keys; use `$result->record($key)` or `$result->data()`.

Top-level response fields: `crew` (block_header), `default_profile` (block_header), `description` (string), `engines` (list of integers), `guns` (list of integers), `images` (block_header), `is_gift` (boolean), `is_premium` (boolean), `is_premium_igr` (boolean), `is_wheeled` (boolean), `modules_tree` (block_header), `multination` (block_header), `name` (string), `nation` (string), `next_tanks` (associative array), `price_credit` (numeric), `price_gold` (numeric), `prices_xp` (associative array), `provisions` (list of integers), `radios` (list of integers), `short_name` (string), `suspensions` (list of integers), `tag` (string), `tank_id` (numeric), `tier` (numeric), `turrets` (list of integers), `type` (string).

Multiget: `prepareVehicles()` accepts identical arguments and returns PreparedOperation without network I/O. Submit it to `executeMany()`. A paginated preparation represents one page.

Pagination: `iterateVehicles()` returns Generator of Record/null; `allVehicles()` returns ApiResult. Both accept the arguments above except pageNo, plus `int $startPage = 1` and `int $maxPages = 1000`. Exhausting the bound throws; all() retains all rows in memory.

<!-- example:encyclopedia/vehicles -->
```php
// Instance call
$result = $client->encyclopedia()->vehicles(
    limit: 10,
);
$data = $result->data();

// Static alternative; configure the corresponding client first.
$result = Encyclopedia::vehicles(
    limit: 10,
);
$data = $result->data();

// Prepare for multiget; instance and static alternatives (no I/O).
$operation = $client->encyclopedia()->prepareVehicles(
    limit: 10,
);
$operation = Encyclopedia::prepareVehicles(
    limit: 10,
);

// Lazy traversal, or collect every page in memory.
$records = $client->encyclopedia()->iterateVehicles(
    limit: 10,
    maxPages: 100,
);
foreach ($records as $key => $record) {
    $row = $record?->data();
}
$all = $client->encyclopedia()->allVehicles(
    limit: 10,
    maxPages: 100,
);

// Static pagination alternatives.
$records = Encyclopedia::iterateVehicles(
    limit: 10,
    maxPages: 100,
);
foreach ($records as $key => $record) {
    $row = $record?->data();
}
$all = Encyclopedia::allVehicles(
    limit: 10,
    maxPages: 100,
);
```

### encyclopedia/vehicleprofile

Read one vehicle's characteristics for a chosen module configuration.

[Official reference](https://developers.wargaming.net/reference/all/wot/encyclopedia/vehicleprofile/). Realms: asia, eu, na.

Signature (identical on service and static facade):

```php
Encyclopedia::vehicleProfile(
    int $tankId,
    array $fields = [],
    string|null $language = null,
    int|null $engineId = null,
    int|null $gunId = null,
    int|null $suspensionId = null,
    int|null $turretId = null,
    int|null $radioId = null,
    string|null $profileId = null,
): ApiResult;
```

| SDK argument / API parameter | Meaning | Required / SDK default | Contract constraints |
| --- | --- | --- | --- |
| `$tankId` / `tank_id` | Vehicle ID(s) from encyclopedia/vehicles. Provider type: `numeric`. | Required | No further bound in the reviewed contract. |
| `$fields` / `fields` | Response field selectors; dot paths include nested fields, a leading minus excludes fields. Provider type: `string, list`. | Optional / `[]` | items/request: 100 |
| `$language` / `language` | Response language; omission uses the client's configured language. Provider type: `string`. | Optional / `null` | values: `en`, `ru`, `pl`, `de`, `fr`, `es`, `zh-cn`, `zh-tw`, `tr`, `cs`, `th`, `vi`, `ko` |
| `$engineId` / `engine_id` | Engine module ID for the selected vehicle. Provider type: `numeric`. | Optional / `null` | No further bound in the reviewed contract. |
| `$gunId` / `gun_id` | Gun module ID for the selected vehicle. Provider type: `numeric`. | Optional / `null` | No further bound in the reviewed contract. |
| `$suspensionId` / `suspension_id` | Suspension module ID for the selected vehicle. Provider type: `numeric`. | Optional / `null` | No further bound in the reviewed contract. |
| `$turretId` / `turret_id` | Turret module ID for the selected vehicle. Provider type: `numeric`. | Optional / `null` | No further bound in the reviewed contract. |
| `$radioId` / `radio_id` | Radio module ID for the selected vehicle. Provider type: `numeric`. | Optional / `null` | No further bound in the reviewed contract. |
| `$profileId` / `profile_id` | Configuration profile ID for the selected vehicle. Provider type: `string`. | Optional / `null` | No further bound in the reviewed contract. |

**Result:** ApiResult. Collection/map of records using WG's original keys; use `$result->record($key)` or `$result->data()`.

Top-level response fields: `ammo` (block_header), `armor` (block_header), `engine` (block_header), `gun` (block_header), `hp` (numeric), `hull_hp` (numeric), `hull_weight` (numeric), `is_default` (boolean), `max_ammo` (numeric), `max_weight` (numeric), `modules` (block_header), `profile_id` (string), `radio` (block_header), `rapid` (block_header), `siege` (block_header), `speed_backward` (numeric), `speed_forward` (numeric), `suspension` (block_header), `tank_id` (numeric), `turret` (block_header), `weight` (numeric).

Multiget: `prepareVehicleProfile()` accepts identical arguments and returns PreparedOperation without network I/O. Submit it to `executeMany()`. A paginated preparation represents one page.

<!-- example:encyclopedia/vehicleprofile -->
```php
// Instance call
$result = $client->encyclopedia()->vehicleProfile(
    tankId: $tankId,
);
$data = $result->data();

// Static alternative; configure the corresponding client first.
$result = Encyclopedia::vehicleProfile(
    tankId: $tankId,
);
$data = $result->data();

// Prepare for multiget; instance and static alternatives (no I/O).
$operation = $client->encyclopedia()->prepareVehicleProfile(
    tankId: $tankId,
);
$operation = Encyclopedia::prepareVehicleProfile(
    tankId: $tankId,
);
```

### encyclopedia/tankengines

Read the deprecated engine catalog; prefer modules().

[Official reference](https://developers.wargaming.net/reference/all/wot/encyclopedia/tankengines/). Realms: asia, eu, na.

**Deprecated:** use the explicit legacy client described above.

Signature (identical on service and static facade):

```php
Encyclopedia::tankEngines(
    string|null $language = null,
    array $fields = [],
    array $moduleIds = [],
    array $nation = [],
): ApiResult;
```

| SDK argument / API parameter | Meaning | Required / SDK default | Contract constraints |
| --- | --- | --- | --- |
| `$language` / `language` | Response language; omission uses the client's configured language. Provider type: `string`. | Optional / `null` | values: `en`, `ru`, `pl`, `de`, `fr`, `es`, `zh-cn`, `zh-tw`, `tr`, `cs`, `th`, `vi`, `ko` |
| `$fields` / `fields` | Response field selectors; dot paths include nested fields, a leading minus excludes fields. Provider type: `string, list`. | Optional / `[]` | items/request: 100 |
| `$moduleIds` / `module_id` | Module ID filter from encyclopedia/modules. Provider type: `numeric, list`. | Optional / `[]` | items/request: 1000 |
| `$nation` / `nation` | Vehicle/module nation filter. Provider type: `string, list`. | Optional / `[]` | items/request: 100 |

**Result:** ApiResult. Collection/map of records using WG's original keys; use `$result->record($key)` or `$result->data()`.

Top-level response fields: `fire_starting_chance` (numeric), `level` (numeric), `module_id` (numeric), `name` (string), `name_i18n` (string), `nation` (string), `nation_i18n` (string), `power` (numeric), `price_credit` (numeric), `price_gold` (numeric), `tanks` (list of integers).

Multiget: `prepareTankEngines()` accepts identical arguments and returns PreparedOperation without network I/O. Submit it to `executeMany()`. A paginated preparation represents one page.

<!-- example:encyclopedia/tankengines -->
```php
// Instance call
$result = $legacyClient->encyclopedia()->tankEngines();
$data = $result->data();

// Static alternative; configure the corresponding client first.
$result = Encyclopedia::tankEngines();
$data = $result->data();

// Prepare for multiget; instance and static alternatives (no I/O).
$operation = $legacyClient->encyclopedia()->prepareTankEngines();
$operation = Encyclopedia::prepareTankEngines();
```

### encyclopedia/tankturrets

Read the deprecated turret catalog; prefer modules().

[Official reference](https://developers.wargaming.net/reference/all/wot/encyclopedia/tankturrets/). Realms: asia, eu, na.

**Deprecated:** use the explicit legacy client described above.

Signature (identical on service and static facade):

```php
Encyclopedia::tankTurrets(
    string|null $language = null,
    array $fields = [],
    array $moduleIds = [],
    array $nation = [],
): ApiResult;
```

| SDK argument / API parameter | Meaning | Required / SDK default | Contract constraints |
| --- | --- | --- | --- |
| `$language` / `language` | Response language; omission uses the client's configured language. Provider type: `string`. | Optional / `null` | values: `en`, `ru`, `pl`, `de`, `fr`, `es`, `zh-cn`, `zh-tw`, `tr`, `cs`, `th`, `vi`, `ko` |
| `$fields` / `fields` | Response field selectors; dot paths include nested fields, a leading minus excludes fields. Provider type: `string, list`. | Optional / `[]` | items/request: 100 |
| `$moduleIds` / `module_id` | Module ID filter from encyclopedia/modules. Provider type: `numeric, list`. | Optional / `[]` | items/request: 1000 |
| `$nation` / `nation` | Vehicle/module nation filter. Provider type: `string, list`. | Optional / `[]` | items/request: 100 |

**Result:** ApiResult. Collection/map of records using WG's original keys; use `$result->record($key)` or `$result->data()`.

Top-level response fields: `armor_board` (numeric), `armor_fedd` (numeric), `armor_forehead` (numeric), `circular_vision_radius` (numeric), `level` (numeric), `module_id` (numeric), `name` (string), `name_i18n` (string), `nation` (string), `nation_i18n` (string), `price_credit` (numeric), `price_gold` (numeric), `rotation_speed` (numeric), `tanks` (list of integers).

Multiget: `prepareTankTurrets()` accepts identical arguments and returns PreparedOperation without network I/O. Submit it to `executeMany()`. A paginated preparation represents one page.

<!-- example:encyclopedia/tankturrets -->
```php
// Instance call
$result = $legacyClient->encyclopedia()->tankTurrets();
$data = $result->data();

// Static alternative; configure the corresponding client first.
$result = Encyclopedia::tankTurrets();
$data = $result->data();

// Prepare for multiget; instance and static alternatives (no I/O).
$operation = $legacyClient->encyclopedia()->prepareTankTurrets();
$operation = Encyclopedia::prepareTankTurrets();
```

### encyclopedia/tankradios

Read the deprecated radio catalog; prefer modules().

[Official reference](https://developers.wargaming.net/reference/all/wot/encyclopedia/tankradios/). Realms: asia, eu, na.

**Deprecated:** use the explicit legacy client described above.

Signature (identical on service and static facade):

```php
Encyclopedia::tankRadios(
    string|null $language = null,
    array $fields = [],
    array $moduleIds = [],
    array $nation = [],
): ApiResult;
```

| SDK argument / API parameter | Meaning | Required / SDK default | Contract constraints |
| --- | --- | --- | --- |
| `$language` / `language` | Response language; omission uses the client's configured language. Provider type: `string`. | Optional / `null` | values: `en`, `ru`, `pl`, `de`, `fr`, `es`, `zh-cn`, `zh-tw`, `tr`, `cs`, `th`, `vi`, `ko` |
| `$fields` / `fields` | Response field selectors; dot paths include nested fields, a leading minus excludes fields. Provider type: `string, list`. | Optional / `[]` | items/request: 100 |
| `$moduleIds` / `module_id` | Module ID filter from encyclopedia/modules. Provider type: `numeric, list`. | Optional / `[]` | items/request: 1000 |
| `$nation` / `nation` | Vehicle/module nation filter. Provider type: `string, list`. | Optional / `[]` | items/request: 100 |

**Result:** ApiResult. Collection/map of records using WG's original keys; use `$result->record($key)` or `$result->data()`.

Top-level response fields: `distance` (numeric), `level` (numeric), `module_id` (numeric), `name` (string), `name_i18n` (string), `nation` (string), `nation_i18n` (string), `price_credit` (numeric), `price_gold` (numeric), `tanks` (list of integers).

Multiget: `prepareTankRadios()` accepts identical arguments and returns PreparedOperation without network I/O. Submit it to `executeMany()`. A paginated preparation represents one page.

<!-- example:encyclopedia/tankradios -->
```php
// Instance call
$result = $legacyClient->encyclopedia()->tankRadios();
$data = $result->data();

// Static alternative; configure the corresponding client first.
$result = Encyclopedia::tankRadios();
$data = $result->data();

// Prepare for multiget; instance and static alternatives (no I/O).
$operation = $legacyClient->encyclopedia()->prepareTankRadios();
$operation = Encyclopedia::prepareTankRadios();
```

### encyclopedia/tankchassis

Read the deprecated suspension catalog; prefer modules().

[Official reference](https://developers.wargaming.net/reference/all/wot/encyclopedia/tankchassis/). Realms: asia, eu, na.

**Deprecated:** use the explicit legacy client described above.

Signature (identical on service and static facade):

```php
Encyclopedia::tankChassis(
    string|null $language = null,
    array $fields = [],
    array $moduleIds = [],
    array $nation = [],
): ApiResult;
```

| SDK argument / API parameter | Meaning | Required / SDK default | Contract constraints |
| --- | --- | --- | --- |
| `$language` / `language` | Response language; omission uses the client's configured language. Provider type: `string`. | Optional / `null` | values: `en`, `ru`, `pl`, `de`, `fr`, `es`, `zh-cn`, `zh-tw`, `tr`, `cs`, `th`, `vi`, `ko` |
| `$fields` / `fields` | Response field selectors; dot paths include nested fields, a leading minus excludes fields. Provider type: `string, list`. | Optional / `[]` | items/request: 100 |
| `$moduleIds` / `module_id` | Module ID filter from encyclopedia/modules. Provider type: `numeric, list`. | Optional / `[]` | items/request: 1000 |
| `$nation` / `nation` | Vehicle/module nation filter. Provider type: `string, list`. | Optional / `[]` | items/request: 100 |

**Result:** ApiResult. Collection/map of records using WG's original keys; use `$result->record($key)` or `$result->data()`.

Top-level response fields: `level` (numeric), `max_load` (float), `module_id` (numeric), `name` (string), `name_i18n` (string), `nation` (string), `nation_i18n` (string), `price_credit` (numeric), `price_gold` (numeric), `rotation_speed` (numeric), `tanks` (list of integers).

Multiget: `prepareTankChassis()` accepts identical arguments and returns PreparedOperation without network I/O. Submit it to `executeMany()`. A paginated preparation represents one page.

<!-- example:encyclopedia/tankchassis -->
```php
// Instance call
$result = $legacyClient->encyclopedia()->tankChassis();
$data = $result->data();

// Static alternative; configure the corresponding client first.
$result = Encyclopedia::tankChassis();
$data = $result->data();

// Prepare for multiget; instance and static alternatives (no I/O).
$operation = $legacyClient->encyclopedia()->prepareTankChassis();
$operation = Encyclopedia::prepareTankChassis();
```

### encyclopedia/tankguns

Read the deprecated gun catalog; prefer modules().

[Official reference](https://developers.wargaming.net/reference/all/wot/encyclopedia/tankguns/). Realms: asia, eu, na.

**Deprecated:** use the explicit legacy client described above.

Signature (identical on service and static facade):

```php
Encyclopedia::tankGuns(
    string|null $language = null,
    array $fields = [],
    array $moduleIds = [],
    array $nation = [],
    int|null $turretId = null,
    int|null $tankId = null,
): ApiResult;
```

| SDK argument / API parameter | Meaning | Required / SDK default | Contract constraints |
| --- | --- | --- | --- |
| `$language` / `language` | Response language; omission uses the client's configured language. Provider type: `string`. | Optional / `null` | values: `en`, `ru`, `pl`, `de`, `fr`, `es`, `zh-cn`, `zh-tw`, `tr`, `cs`, `th`, `vi`, `ko` |
| `$fields` / `fields` | Response field selectors; dot paths include nested fields, a leading minus excludes fields. Provider type: `string, list`. | Optional / `[]` | items/request: 100 |
| `$moduleIds` / `module_id` | Module ID filter from encyclopedia/modules. Provider type: `numeric, list`. | Optional / `[]` | items/request: 1000 |
| `$nation` / `nation` | Vehicle/module nation filter. Provider type: `string, list`. | Optional / `[]` | items/request: 100 |
| `$turretId` / `turret_id` | Turret module ID for the selected vehicle. Provider type: `numeric`. | Optional / `null` | No further bound in the reviewed contract. |
| `$tankId` / `tank_id` | Vehicle ID(s) from encyclopedia/vehicles. Provider type: `numeric`. | Optional / `null` | No further bound in the reviewed contract. |

**Result:** ApiResult. Collection/map of records using WG's original keys; use `$result->record($key)` or `$result->data()`.

Top-level response fields: `damage` (list of integers), `level` (numeric), `module_id` (numeric), `name` (string), `name_i18n` (string), `nation` (string), `nation_i18n` (string), `piercing_power` (list of integers), `price_credit` (numeric), `price_gold` (numeric), `rate` (float), `tanks` (list of integers), `turrets` (list of integers).

Multiget: `prepareTankGuns()` accepts identical arguments and returns PreparedOperation without network I/O. Submit it to `executeMany()`. A paginated preparation represents one page.

<!-- example:encyclopedia/tankguns -->
```php
// Instance call
$result = $legacyClient->encyclopedia()->tankGuns();
$data = $result->data();

// Static alternative; configure the corresponding client first.
$result = Encyclopedia::tankGuns();
$data = $result->data();

// Prepare for multiget; instance and static alternatives (no I/O).
$operation = $legacyClient->encyclopedia()->prepareTankGuns();
$operation = Encyclopedia::prepareTankGuns();
```

### encyclopedia/achievements

Read achievement definitions and display metadata.

[Official reference](https://developers.wargaming.net/reference/all/wot/encyclopedia/achievements/). Realms: asia, eu, na.

Signature (identical on service and static facade):

```php
Encyclopedia::achievements(
    array $fields = [],
    string|null $language = null,
): ApiResult;
```

| SDK argument / API parameter | Meaning | Required / SDK default | Contract constraints |
| --- | --- | --- | --- |
| `$fields` / `fields` | Response field selectors; dot paths include nested fields, a leading minus excludes fields. Provider type: `string, list`. | Optional / `[]` | items/request: 100 |
| `$language` / `language` | Response language; omission uses the client's configured language. Provider type: `string`. | Optional / `null` | values: `en`, `ru`, `pl`, `de`, `fr`, `es`, `zh-cn`, `zh-tw`, `tr`, `cs`, `th`, `vi`, `ko` |

**Result:** ApiResult. Collection/map of records using WG's original keys; use `$result->record($key)` or `$result->data()`.

Top-level response fields: `condition` (string), `description` (string), `hero_info` (string), `image` (string), `image_big` (string), `name` (string), `name_i18n` (string), `options` (block_header), `order` (numeric), `outdated` (boolean), `section` (string), `section_order` (numeric), `type` (string).

Multiget: `prepareAchievements()` accepts identical arguments and returns PreparedOperation without network I/O. Submit it to `executeMany()`. A paginated preparation represents one page.

<!-- example:encyclopedia/achievements -->
```php
// Instance call
$result = $client->encyclopedia()->achievements();
$data = $result->data();

// Static alternative; configure the corresponding client first.
$result = Encyclopedia::achievements();
$data = $result->data();

// Prepare for multiget; instance and static alternatives (no I/O).
$operation = $client->encyclopedia()->prepareAchievements();
$operation = Encyclopedia::prepareAchievements();
```

### encyclopedia/info

Read encyclopedia metadata, game version and supported vehicle categories.

[Official reference](https://developers.wargaming.net/reference/all/wot/encyclopedia/info/). Realms: asia, eu, na.

Signature (identical on service and static facade):

```php
Encyclopedia::info(
    array $fields = [],
    string|null $language = null,
): ApiResult;
```

| SDK argument / API parameter | Meaning | Required / SDK default | Contract constraints |
| --- | --- | --- | --- |
| `$fields` / `fields` | Response field selectors; dot paths include nested fields, a leading minus excludes fields. Provider type: `string, list`. | Optional / `[]` | items/request: 100 |
| `$language` / `language` | Response language; omission uses the client's configured language. Provider type: `string`. | Optional / `null` | values: `en`, `ru`, `pl`, `de`, `fr`, `es`, `zh-cn`, `zh-tw`, `tr`, `cs`, `th`, `vi`, `ko` |

**Result:** ApiResult. Single object; use `$result->object()` or `$result->data()`.

Top-level response fields: `achievement_sections` (block_header), `game_version` (string), `languages` (associative array), `tanks_updated_at` (timestamp), `vehicle_crew_roles` (associative array), `vehicle_nations` (associative array), `vehicle_types` (associative array).

Multiget: `prepareInfo()` accepts identical arguments and returns PreparedOperation without network I/O. Submit it to `executeMany()`. A paginated preparation represents one page.

<!-- example:encyclopedia/info -->
```php
// Instance call
$result = $client->encyclopedia()->info();
$data = $result->data();

// Static alternative; configure the corresponding client first.
$result = Encyclopedia::info();
$data = $result->data();

// Prepare for multiget; instance and static alternatives (no I/O).
$operation = $client->encyclopedia()->prepareInfo();
$operation = Encyclopedia::prepareInfo();
```

### encyclopedia/arenas

Read battle arena definitions.

[Official reference](https://developers.wargaming.net/reference/all/wot/encyclopedia/arenas/). Realms: asia, eu, na.

Signature (identical on service and static facade):

```php
Encyclopedia::arenas(
    array $fields = [],
    string|null $language = null,
): ApiResult;
```

| SDK argument / API parameter | Meaning | Required / SDK default | Contract constraints |
| --- | --- | --- | --- |
| `$fields` / `fields` | Response field selectors; dot paths include nested fields, a leading minus excludes fields. Provider type: `string, list`. | Optional / `[]` | items/request: 100 |
| `$language` / `language` | Response language; omission uses the client's configured language. Provider type: `string`. | Optional / `null` | values: `en`, `ru`, `pl`, `de`, `fr`, `es`, `zh-cn`, `zh-tw`, `tr`, `cs`, `th`, `vi`, `ko` |

**Result:** ApiResult. Collection/map of records using WG's original keys; use `$result->record($key)` or `$result->data()`.

Top-level response fields: `arena_id` (string), `camouflage_type` (string), `description` (string), `name_i18n` (string).

Multiget: `prepareArenas()` accepts identical arguments and returns PreparedOperation without network I/O. Submit it to `executeMany()`. A paginated preparation represents one page.

<!-- example:encyclopedia/arenas -->
```php
// Instance call
$result = $client->encyclopedia()->arenas();
$data = $result->data();

// Static alternative; configure the corresponding client first.
$result = Encyclopedia::arenas();
$data = $result->data();

// Prepare for multiget; instance and static alternatives (no I/O).
$operation = $client->encyclopedia()->prepareArenas();
$operation = Encyclopedia::prepareArenas();
```

### encyclopedia/provisions

Read equipment and consumable definitions.

[Official reference](https://developers.wargaming.net/reference/all/wot/encyclopedia/provisions/). Realms: asia, eu, na.

Signature (identical on service and static facade):

```php
Encyclopedia::provisions(
    array $fields = [],
    string|null $language = null,
    int|null $pageNo = null,
    int|null $limit = null,
    array $type = [],
    array $provisionIds = [],
): ApiResult;
```

| SDK argument / API parameter | Meaning | Required / SDK default | Contract constraints |
| --- | --- | --- | --- |
| `$fields` / `fields` | Response field selectors; dot paths include nested fields, a leading minus excludes fields. Provider type: `string, list`. | Optional / `[]` | items/request: 100 |
| `$language` / `language` | Response language; omission uses the client's configured language. Provider type: `string`. | Optional / `null` | values: `en`, `ru`, `pl`, `de`, `fr`, `es`, `zh-cn`, `zh-tw`, `tr`, `cs`, `th`, `vi`, `ko` |
| `$pageNo` / `page_no` | One-based page number; use iterate/all helpers to traverse pages. Provider type: `numeric`. | Optional / `null` | No further bound in the reviewed contract. |
| `$limit` / `limit` | Maximum number of rows requested per page or response. Provider type: `numeric`. | Optional / `null` | maximum: 100 |
| `$type` / `type` | Search mode, catalog category or rating type, depending on this endpoint. Provider type: `string, list`. | Optional / `[]` | items/request: 100; values: `equipment`, `optionalDevice` |
| `$provisionIds` / `provision_id` | Equipment/consumable ID filter from encyclopedia/provisions. Provider type: `numeric, list`. | Optional / `[]` | items/request: 100 |

**Result:** ApiResult. Collection/map of records using WG's original keys; use `$result->record($key)` or `$result->data()`.

Top-level response fields: `description` (string), `image` (string), `name` (string), `price_credit` (numeric), `price_gold` (numeric), `provision_id` (numeric), `tag` (string), `type` (string), `weight` (numeric).

Multiget: `prepareProvisions()` accepts identical arguments and returns PreparedOperation without network I/O. Submit it to `executeMany()`. A paginated preparation represents one page.

Pagination: `iterateProvisions()` returns Generator of Record/null; `allProvisions()` returns ApiResult. Both accept the arguments above except pageNo, plus `int $startPage = 1` and `int $maxPages = 1000`. Exhausting the bound throws; all() retains all rows in memory.

<!-- example:encyclopedia/provisions -->
```php
// Instance call
$result = $client->encyclopedia()->provisions(
    limit: 10,
);
$data = $result->data();

// Static alternative; configure the corresponding client first.
$result = Encyclopedia::provisions(
    limit: 10,
);
$data = $result->data();

// Prepare for multiget; instance and static alternatives (no I/O).
$operation = $client->encyclopedia()->prepareProvisions(
    limit: 10,
);
$operation = Encyclopedia::prepareProvisions(
    limit: 10,
);

// Lazy traversal, or collect every page in memory.
$records = $client->encyclopedia()->iterateProvisions(
    limit: 10,
    maxPages: 100,
);
foreach ($records as $key => $record) {
    $row = $record?->data();
}
$all = $client->encyclopedia()->allProvisions(
    limit: 10,
    maxPages: 100,
);

// Static pagination alternatives.
$records = Encyclopedia::iterateProvisions(
    limit: 10,
    maxPages: 100,
);
foreach ($records as $key => $record) {
    $row = $record?->data();
}
$all = Encyclopedia::allProvisions(
    limit: 10,
    maxPages: 100,
);
```

### encyclopedia/personalmissions

Read personal mission campaigns, operations and tasks.

[Official reference](https://developers.wargaming.net/reference/all/wot/encyclopedia/personalmissions/). Realms: asia, eu, na.

Signature (identical on service and static facade):

```php
Encyclopedia::personalMissions(
    array $fields = [],
    string|null $language = null,
    array $campaignIds = [],
    array $operationIds = [],
    array $setIds = [],
    array $tag = [],
): ApiResult;
```

| SDK argument / API parameter | Meaning | Required / SDK default | Contract constraints |
| --- | --- | --- | --- |
| `$fields` / `fields` | Response field selectors; dot paths include nested fields, a leading minus excludes fields. Provider type: `string, list`. | Optional / `[]` | items/request: 100 |
| `$language` / `language` | Response language; omission uses the client's configured language. Provider type: `string`. | Optional / `null` | values: `en`, `ru`, `pl`, `de`, `fr`, `es`, `zh-cn`, `zh-tw`, `tr`, `cs`, `th`, `vi`, `ko` |
| `$campaignIds` / `campaign_id` | Personal mission campaign ID filter. Provider type: `numeric, list`. | Optional / `[]` | items/request: 100 |
| `$operationIds` / `operation_id` | Personal mission operation ID filter. Provider type: `numeric, list`. | Optional / `[]` | items/request: 100 |
| `$setIds` / `set_id` | Equipment/consumable set filter. Provider type: `numeric, list`. | Optional / `[]` | items/request: 100 |
| `$tag` / `tag` | Clan tag filter. Provider type: `string, list`. | Optional / `[]` | items/request: 100 |

**Result:** ApiResult. Collection/map of records using WG's original keys; use `$result->record($key)` or `$result->data()`.

Top-level response fields: `campaign_id` (numeric), `description` (string), `name` (string), `operations` (block_header).

Multiget: `preparePersonalMissions()` accepts identical arguments and returns PreparedOperation without network I/O. Submit it to `executeMany()`. A paginated preparation represents one page.

<!-- example:encyclopedia/personalmissions -->
```php
// Instance call
$result = $client->encyclopedia()->personalMissions();
$data = $result->data();

// Static alternative; configure the corresponding client first.
$result = Encyclopedia::personalMissions();
$data = $result->data();

// Prepare for multiget; instance and static alternatives (no I/O).
$operation = $client->encyclopedia()->preparePersonalMissions();
$operation = Encyclopedia::preparePersonalMissions();
```

### encyclopedia/boosters

Read personal reserve definitions.

[Official reference](https://developers.wargaming.net/reference/all/wot/encyclopedia/boosters/). Realms: asia, eu, na.

Signature (identical on service and static facade):

```php
Encyclopedia::boosters(
    array $fields = [],
    string|null $language = null,
): ApiResult;
```

| SDK argument / API parameter | Meaning | Required / SDK default | Contract constraints |
| --- | --- | --- | --- |
| `$fields` / `fields` | Response field selectors; dot paths include nested fields, a leading minus excludes fields. Provider type: `string, list`. | Optional / `[]` | items/request: 100 |
| `$language` / `language` | Response language; omission uses the client's configured language. Provider type: `string`. | Optional / `null` | values: `en`, `ru`, `pl`, `de`, `fr`, `es`, `zh-cn`, `zh-tw`, `tr`, `cs`, `th`, `vi`, `ko` |

**Result:** ApiResult. Collection/map of records using WG's original keys; use `$result->record($key)` or `$result->data()`.

Top-level response fields: `booster_id` (numeric), `description` (string), `expires_at` (timestamp), `images` (block_header), `is_auto` (boolean), `lifetime` (numeric), `name` (string), `price_credit` (numeric), `price_gold` (numeric), `resource` (string).

Multiget: `prepareBoosters()` accepts identical arguments and returns PreparedOperation without network I/O. Submit it to `executeMany()`. A paginated preparation represents one page.

<!-- example:encyclopedia/boosters -->
```php
// Instance call
$result = $client->encyclopedia()->boosters();
$data = $result->data();

// Static alternative; configure the corresponding client first.
$result = Encyclopedia::boosters();
$data = $result->data();

// Prepare for multiget; instance and static alternatives (no I/O).
$operation = $client->encyclopedia()->prepareBoosters();
$operation = Encyclopedia::prepareBoosters();
```

### encyclopedia/vehicleprofiles

Read the available configuration profiles for one vehicle.

[Official reference](https://developers.wargaming.net/reference/all/wot/encyclopedia/vehicleprofiles/). Realms: asia, eu, na.

Signature (identical on service and static facade):

```php
Encyclopedia::vehicleProfiles(
    int $tankId,
    array $fields = [],
    string|null $language = null,
    string|null $orderBy = null,
): ApiResult;
```

| SDK argument / API parameter | Meaning | Required / SDK default | Contract constraints |
| --- | --- | --- | --- |
| `$tankId` / `tank_id` | Vehicle ID(s) from encyclopedia/vehicles. Provider type: `numeric`. | Required | No further bound in the reviewed contract. |
| `$fields` / `fields` | Response field selectors; dot paths include nested fields, a leading minus excludes fields. Provider type: `string, list`. | Optional / `[]` | items/request: 100 |
| `$language` / `language` | Response language; omission uses the client's configured language. Provider type: `string`. | Optional / `null` | values: `en`, `ru`, `pl`, `de`, `fr`, `es`, `zh-cn`, `zh-tw`, `tr`, `cs`, `th`, `vi`, `ko` |
| `$orderBy` / `order_by` | Provider sort order. Provider type: `string`. | Optional / `null` | values: `price_credit`, `-price_credit` |

**Result:** ApiResult. Collection/map of records using WG's original keys; use `$result->record($key)` or `$result->data()`.

Top-level response fields: `is_default` (boolean), `price_credit` (numeric), `profile_id` (string), `tank_id` (numeric).

Multiget: `prepareVehicleProfiles()` accepts identical arguments and returns PreparedOperation without network I/O. Submit it to `executeMany()`. A paginated preparation represents one page.

<!-- example:encyclopedia/vehicleprofiles -->
```php
// Instance call
$result = $client->encyclopedia()->vehicleProfiles(
    tankId: $tankId,
);
$data = $result->data();

// Static alternative; configure the corresponding client first.
$result = Encyclopedia::vehicleProfiles(
    tankId: $tankId,
);
$data = $result->data();

// Prepare for multiget; instance and static alternatives (no I/O).
$operation = $client->encyclopedia()->prepareVehicleProfiles(
    tankId: $tankId,
);
$operation = Encyclopedia::prepareVehicleProfiles(
    tankId: $tankId,
);
```

### encyclopedia/modules

Read vehicle module definitions.

[Official reference](https://developers.wargaming.net/reference/all/wot/encyclopedia/modules/). Realms: asia, eu, na.

Signature (identical on service and static facade):

```php
Encyclopedia::modules(
    array $fields = [],
    array $extra = [],
    string|null $language = null,
    int|null $pageNo = null,
    int|null $limit = null,
    array $moduleIds = [],
    array $type = [],
    array $nation = [],
): ApiResult;
```

| SDK argument / API parameter | Meaning | Required / SDK default | Contract constraints |
| --- | --- | --- | --- |
| `$fields` / `fields` | Response field selectors; dot paths include nested fields, a leading minus excludes fields. Provider type: `string, list`. | Optional / `[]` | items/request: 100 |
| `$extra` / `extra` | Additional response fields; only the listed selectors are supported. Provider type: `string, list`. | Optional / `[]` | values: `default_profile` |
| `$language` / `language` | Response language; omission uses the client's configured language. Provider type: `string`. | Optional / `null` | values: `en`, `ru`, `pl`, `de`, `fr`, `es`, `zh-cn`, `zh-tw`, `tr`, `cs`, `th`, `vi`, `ko` |
| `$pageNo` / `page_no` | One-based page number; use iterate/all helpers to traverse pages. Provider type: `numeric`. | Optional / `null` | No further bound in the reviewed contract. |
| `$limit` / `limit` | Maximum number of rows requested per page or response. Provider type: `numeric`. | Optional / `null` | maximum: 100 |
| `$moduleIds` / `module_id` | Module ID filter from encyclopedia/modules. Provider type: `numeric, list`. | Optional / `[]` | items/request: 100 |
| `$type` / `type` | Search mode, catalog category or rating type, depending on this endpoint. Provider type: `string, list`. | Optional / `[]` | items/request: 100; values: `vehicleRadio`, `vehicleEngine`, `vehicleGun`, `vehicleChassis`, `vehicleTurret` |
| `$nation` / `nation` | Vehicle/module nation filter. Provider type: `string, list`. | Optional / `[]` | items/request: 100 |

**Result:** ApiResult. Collection/map of records using WG's original keys; use `$result->record($key)` or `$result->data()`.

Top-level response fields: `default_profile` (block_header), `image` (string), `module_id` (numeric), `name` (string), `nation` (string), `price_credit` (numeric), `tanks` (list of integers), `tier` (numeric), `type` (string), `weight` (numeric).

Multiget: `prepareModules()` accepts identical arguments and returns PreparedOperation without network I/O. Submit it to `executeMany()`. A paginated preparation represents one page.

Pagination: `iterateModules()` returns Generator of Record/null; `allModules()` returns ApiResult. Both accept the arguments above except pageNo, plus `int $startPage = 1` and `int $maxPages = 1000`. Exhausting the bound throws; all() retains all rows in memory.

<!-- example:encyclopedia/modules -->
```php
// Instance call
$result = $client->encyclopedia()->modules(
    limit: 10,
);
$data = $result->data();

// Static alternative; configure the corresponding client first.
$result = Encyclopedia::modules(
    limit: 10,
);
$data = $result->data();

// Prepare for multiget; instance and static alternatives (no I/O).
$operation = $client->encyclopedia()->prepareModules(
    limit: 10,
);
$operation = Encyclopedia::prepareModules(
    limit: 10,
);

// Lazy traversal, or collect every page in memory.
$records = $client->encyclopedia()->iterateModules(
    limit: 10,
    maxPages: 100,
);
foreach ($records as $key => $record) {
    $row = $record?->data();
}
$all = $client->encyclopedia()->allModules(
    limit: 10,
    maxPages: 100,
);

// Static pagination alternatives.
$records = Encyclopedia::iterateModules(
    limit: 10,
    maxPages: 100,
);
foreach ($records as $key => $record) {
    $row = $record?->data();
}
$all = Encyclopedia::allModules(
    limit: 10,
    maxPages: 100,
);
```

### encyclopedia/badges

Read badge definitions and display metadata.

[Official reference](https://developers.wargaming.net/reference/all/wot/encyclopedia/badges/). Realms: asia, eu, na.

Signature (identical on service and static facade):

```php
Encyclopedia::badges(
    array $fields = [],
    string|null $language = null,
): ApiResult;
```

| SDK argument / API parameter | Meaning | Required / SDK default | Contract constraints |
| --- | --- | --- | --- |
| `$fields` / `fields` | Response field selectors; dot paths include nested fields, a leading minus excludes fields. Provider type: `string, list`. | Optional / `[]` | items/request: 100 |
| `$language` / `language` | Response language; omission uses the client's configured language. Provider type: `string`. | Optional / `null` | values: `en`, `ru`, `pl`, `de`, `fr`, `es`, `zh-cn`, `zh-tw`, `tr`, `cs`, `th`, `vi`, `ko` |

**Result:** ApiResult. Collection/map of records using WG's original keys; use `$result->record($key)` or `$result->data()`.

Top-level response fields: `badge_id` (numeric), `description` (string), `images` (block_header), `name` (string).

Multiget: `prepareBadges()` accepts identical arguments and returns PreparedOperation without network I/O. Submit it to `executeMany()`. A paginated preparation represents one page.

<!-- example:encyclopedia/badges -->
```php
// Instance call
$result = $client->encyclopedia()->badges();
$data = $result->data();

// Static alternative; configure the corresponding client first.
$result = Encyclopedia::badges();
$data = $result->data();

// Prepare for multiget; instance and static alternatives (no I/O).
$operation = $client->encyclopedia()->prepareBadges();
$operation = Encyclopedia::prepareBadges();
```

### encyclopedia/crewroles

Read crew role definitions.

[Official reference](https://developers.wargaming.net/reference/all/wot/encyclopedia/crewroles/). Realms: asia, eu, na.

Signature (identical on service and static facade):

```php
Encyclopedia::crewRoles(
    array $fields = [],
    string|null $language = null,
    array $role = [],
): ApiResult;
```

| SDK argument / API parameter | Meaning | Required / SDK default | Contract constraints |
| --- | --- | --- | --- |
| `$fields` / `fields` | Response field selectors; dot paths include nested fields, a leading minus excludes fields. Provider type: `string, list`. | Optional / `[]` | items/request: 100 |
| `$language` / `language` | Response language; omission uses the client's configured language. Provider type: `string`. | Optional / `null` | values: `en`, `ru`, `pl`, `de`, `fr`, `es`, `zh-cn`, `zh-tw`, `tr`, `cs`, `th`, `vi`, `ko` |
| `$role` / `role` | Crew role filter. Provider type: `string, list`. | Optional / `[]` | items/request: 100 |

**Result:** ApiResult. Collection/map of records using WG's original keys; use `$result->record($key)` or `$result->data()`.

Top-level response fields: `name` (string), `role` (string), `skills` (list of strings).

Multiget: `prepareCrewRoles()` accepts identical arguments and returns PreparedOperation without network I/O. Submit it to `executeMany()`. A paginated preparation represents one page.

<!-- example:encyclopedia/crewroles -->
```php
// Instance call
$result = $client->encyclopedia()->crewRoles();
$data = $result->data();

// Static alternative; configure the corresponding client first.
$result = Encyclopedia::crewRoles();
$data = $result->data();

// Prepare for multiget; instance and static alternatives (no I/O).
$operation = $client->encyclopedia()->prepareCrewRoles();
$operation = Encyclopedia::prepareCrewRoles();
```

### encyclopedia/crewskills

Read crew skill and perk definitions.

[Official reference](https://developers.wargaming.net/reference/all/wot/encyclopedia/crewskills/). Realms: asia, eu, na.

Signature (identical on service and static facade):

```php
Encyclopedia::crewSkills(
    array $fields = [],
    string|null $language = null,
    array $skill = [],
    string|null $role = null,
): ApiResult;
```

| SDK argument / API parameter | Meaning | Required / SDK default | Contract constraints |
| --- | --- | --- | --- |
| `$fields` / `fields` | Response field selectors; dot paths include nested fields, a leading minus excludes fields. Provider type: `string, list`. | Optional / `[]` | items/request: 100 |
| `$language` / `language` | Response language; omission uses the client's configured language. Provider type: `string`. | Optional / `null` | values: `en`, `ru`, `pl`, `de`, `fr`, `es`, `zh-cn`, `zh-tw`, `tr`, `cs`, `th`, `vi`, `ko` |
| `$skill` / `skill` | Crew skill filter. Provider type: `string, list`. | Optional / `[]` | items/request: 100 |
| `$role` / `role` | Crew role filter. Provider type: `string`. | Optional / `null` | No further bound in the reviewed contract. |

**Result:** ApiResult. Collection/map of records using WG's original keys; use `$result->record($key)` or `$result->data()`.

Top-level response fields: `description` (string), `image_url` (block_header), `is_perk` (boolean), `name` (string), `skill` (string).

Multiget: `prepareCrewSkills()` accepts identical arguments and returns PreparedOperation without network I/O. Submit it to `executeMany()`. A paginated preparation represents one page.

<!-- example:encyclopedia/crewskills -->
```php
// Instance call
$result = $client->encyclopedia()->crewSkills();
$data = $result->data();

// Static alternative; configure the corresponding client first.
$result = Encyclopedia::crewSkills();
$data = $result->data();

// Prepare for multiget; instance and static alternatives (no I/O).
$operation = $client->encyclopedia()->prepareCrewSkills();
$operation = Encyclopedia::prepareCrewSkills();
```

## clans

### clans/list

Search clans by name or tag, or list clans with optional filters.

[Official reference](https://developers.wargaming.net/reference/all/wot/clans/list/). Realms: asia, eu, na.

Signature (identical on service and static facade):

```php
Clans::search(
    string|null $language = null,
    array $fields = [],
    string|null $search = null,
    int|null $limit = null,
    int|null $pageNo = null,
): ApiResult;
```

| SDK argument / API parameter | Meaning | Required / SDK default | Contract constraints |
| --- | --- | --- | --- |
| `$language` / `language` | Response language; omission uses the client's configured language. Provider type: `string`. | Optional / `null` | values: `en`, `ru`, `pl`, `de`, `fr`, `es`, `zh-cn`, `zh-tw`, `tr`, `cs`, `th`, `vi`, `ko` |
| `$fields` / `fields` | Response field selectors; dot paths include nested fields, a leading minus excludes fields. Provider type: `string, list`. | Optional / `[]` | items/request: 100 |
| `$search` / `search` | Nickname, clan name or clan tag search text, depending on the method. Provider type: `string`. | Optional / `null` | minimum length: 2 |
| `$limit` / `limit` | Maximum number of rows requested per page or response. Provider type: `numeric`. | Optional / `null` | maximum: 100 |
| `$pageNo` / `page_no` | One-based page number; use iterate/all helpers to traverse pages. Provider type: `numeric`. | Optional / `null` | No further bound in the reviewed contract. |

**Result:** ApiResult. Collection/map of records using WG's original keys; use `$result->record($key)` or `$result->data()`.

Top-level response fields: `clan_id` (numeric), `color` (string), `created_at` (timestamp), `emblems` (block_header), `members_count` (numeric), `name` (string), `tag` (string).

Multiget: `prepareSearch()` accepts identical arguments and returns PreparedOperation without network I/O. Submit it to `executeMany()`. A paginated preparation represents one page.

Pagination: `iterateSearch()` returns Generator of Record/null; `allSearch()` returns ApiResult. Both accept the arguments above except pageNo, plus `int $startPage = 1` and `int $maxPages = 1000`. Exhausting the bound throws; all() retains all rows in memory.

<!-- example:clans/list -->
```php
// Instance call
$result = $client->clans()->search(
    search: 'WOT',
    limit: 10,
);
$data = $result->data();

// Static alternative; configure the corresponding client first.
$result = Clans::search(
    search: 'WOT',
    limit: 10,
);
$data = $result->data();

// Prepare for multiget; instance and static alternatives (no I/O).
$operation = $client->clans()->prepareSearch(
    search: 'WOT',
    limit: 10,
);
$operation = Clans::prepareSearch(
    search: 'WOT',
    limit: 10,
);

// Lazy traversal, or collect every page in memory.
$records = $client->clans()->iterateSearch(
    search: 'WOT',
    limit: 10,
    maxPages: 100,
);
foreach ($records as $key => $record) {
    $row = $record?->data();
}
$all = $client->clans()->allSearch(
    search: 'WOT',
    limit: 10,
    maxPages: 100,
);

// Static pagination alternatives.
$records = Clans::iterateSearch(
    search: 'WOT',
    limit: 10,
    maxPages: 100,
);
foreach ($records as $key => $record) {
    $row = $record?->data();
}
$all = Clans::allSearch(
    search: 'WOT',
    limit: 10,
    maxPages: 100,
);
```

### clans/info

Read clan profiles and membership information.

[Official reference](https://developers.wargaming.net/reference/all/wot/clans/info/). Realms: asia, eu, na.

Signature (identical on service and static facade):

```php
Clans::info(
    array $clanIds,
    string|null $language = null,
    array $fields = [],
    AccessToken|null $accessToken = null,
    array $extra = [],
    string|null $membersKey = null,
): ApiResult;
```

| SDK argument / API parameter | Meaning | Required / SDK default | Contract constraints |
| --- | --- | --- | --- |
| `$clanIds` / `clan_id` | Absolute clan ID(s) in the selected realm. Provider type: `numeric, list`. | Required | items/request: 100 Required IDs are deduplicated and automatically batched at this limit. |
| `$language` / `language` | Response language; omission uses the client's configured language. Provider type: `string`. | Optional / `null` | values: `en`, `ru`, `pl`, `de`, `fr`, `es`, `zh-cn`, `zh-tw`, `tr`, `cs`, `th`, `vi`, `ko` |
| `$fields` / `fields` | Response field selectors; dot paths include nested fields, a leading minus excludes fields. Provider type: `string, list`. | Optional / `[]` | items/request: 100 |
| `$accessToken` / `access_token` | Verified, unexpired WgAuth token for the selected realm. Provider type: `string`. | Optional / `null` | No further bound in the reviewed contract. |
| `$extra` / `extra` | Additional response fields; only the listed selectors are supported. Provider type: `string, list`. | Optional / `[]` | values: `private.online_members` |
| `$membersKey` / `members_key` | How clan member rows are indexed in the response. Provider type: `string`. | Optional / `null` | values: `id` |

**Result:** ApiResult. Collection/map of records using WG's original keys; use `$result->record($key)` or `$result->data()`.

Top-level response fields: `accepts_join_requests` (boolean), `clan_id` (numeric), `color` (string), `created_at` (timestamp), `creator_id` (numeric), `creator_name` (string), `description` (string), `description_html` (string), `emblems` (block_header), `is_clan_disbanded` (boolean), `leader_id` (numeric), `leader_name` (string), `members` (block_header), `members_count` (numeric), `motto` (string), `name` (string), `old_name` (string), `old_tag` (string), `private` (block_header), `renamed_at` (timestamp), `tag` (string), `updated_at` (timestamp).

Multiget: `prepareInfo()` accepts identical arguments and returns PreparedOperation without network I/O. Submit it to `executeMany()`. A paginated preparation represents one page.

<!-- example:clans/info -->
```php
// Instance call
$result = $client->clans()->info(
    clanIds: [$clanId],
);
$data = $result->data();

// Static alternative; configure the corresponding client first.
$result = Clans::info(
    clanIds: [$clanId],
);
$data = $result->data();

// Prepare for multiget; instance and static alternatives (no I/O).
$operation = $client->clans()->prepareInfo(
    clanIds: [$clanId],
);
$operation = Clans::prepareInfo(
    clanIds: [$clanId],
);
```

### clans/accountinfo

Read clan membership information for selected accounts.

[Official reference](https://developers.wargaming.net/reference/all/wot/clans/accountinfo/). Realms: asia, eu, na.

Signature (identical on service and static facade):

```php
Clans::accountInfo(
    array $accountIds,
    string|null $language = null,
    array $fields = [],
): ApiResult;
```

| SDK argument / API parameter | Meaning | Required / SDK default | Contract constraints |
| --- | --- | --- | --- |
| `$accountIds` / `account_id` | Absolute player account ID(s) in the selected realm. Provider type: `numeric, list`. | Required | items/request: 100 Required IDs are deduplicated and automatically batched at this limit. |
| `$language` / `language` | Response language; omission uses the client's configured language. Provider type: `string`. | Optional / `null` | values: `en`, `ru`, `pl`, `de`, `fr`, `es`, `zh-cn`, `zh-tw`, `tr`, `cs`, `th`, `vi`, `ko` |
| `$fields` / `fields` | Response field selectors; dot paths include nested fields, a leading minus excludes fields. Provider type: `string, list`. | Optional / `[]` | items/request: 100 |

**Result:** ApiResult. Collection/map of records using WG's original keys; use `$result->record($key)` or `$result->data()`.

Top-level response fields: `account_id` (numeric), `account_name` (string), `clan` (block_header), `joined_at` (timestamp), `role` (string), `role_i18n` (string).

Multiget: `prepareAccountInfo()` accepts identical arguments and returns PreparedOperation without network I/O. Submit it to `executeMany()`. A paginated preparation represents one page.

<!-- example:clans/accountinfo -->
```php
// Instance call
$result = $client->clans()->accountInfo(
    accountIds: [$accountId],
);
$data = $result->data();

// Static alternative; configure the corresponding client first.
$result = Clans::accountInfo(
    accountIds: [$accountId],
);
$data = $result->data();

// Prepare for multiget; instance and static alternatives (no I/O).
$operation = $client->clans()->prepareAccountInfo(
    accountIds: [$accountId],
);
$operation = Clans::prepareAccountInfo(
    accountIds: [$accountId],
);
```

### clans/glossary

Read clan-related terminology and role labels.

[Official reference](https://developers.wargaming.net/reference/all/wot/clans/glossary/). Realms: asia, eu, na.

Signature (identical on service and static facade):

```php
Clans::glossary(
    string|null $language = null,
    array $fields = [],
): ApiResult;
```

| SDK argument / API parameter | Meaning | Required / SDK default | Contract constraints |
| --- | --- | --- | --- |
| `$language` / `language` | Response language; omission uses the client's configured language. Provider type: `string`. | Optional / `null` | values: `en`, `ru`, `pl`, `de`, `fr`, `es`, `zh-cn`, `zh-tw`, `tr`, `cs`, `th`, `vi`, `ko` |
| `$fields` / `fields` | Response field selectors; dot paths include nested fields, a leading minus excludes fields. Provider type: `string, list`. | Optional / `[]` | items/request: 100 |

**Result:** ApiResult. Single object; use `$result->object()` or `$result->data()`.

Top-level response fields: `clans_roles` (associative array).

Multiget: `prepareGlossary()` accepts identical arguments and returns PreparedOperation without network I/O. Submit it to `executeMany()`. A paginated preparation represents one page.

<!-- example:clans/glossary -->
```php
// Instance call
$result = $client->clans()->glossary();
$data = $result->data();

// Static alternative; configure the corresponding client first.
$result = Clans::glossary();
$data = $result->data();

// Prepare for multiget; instance and static alternatives (no I/O).
$operation = $client->clans()->prepareGlossary();
$operation = Clans::prepareGlossary();
```

### clans/messageboard

Read the authenticated player's clan message board.

[Official reference](https://developers.wargaming.net/reference/all/wot/clans/messageboard/). Realms: asia, eu, na.

Signature (identical on service and static facade):

```php
Clans::messageboard(
    AccessToken $accessToken,
    array $fields = [],
): ApiResult;
```

| SDK argument / API parameter | Meaning | Required / SDK default | Contract constraints |
| --- | --- | --- | --- |
| `$accessToken` / `access_token` | Verified, unexpired WgAuth token for the selected realm. Provider type: `string`. | Required | No further bound in the reviewed contract. |
| `$fields` / `fields` | Response field selectors; dot paths include nested fields, a leading minus excludes fields. Provider type: `string, list`. | Optional / `[]` | items/request: 100 |

**Result:** ApiResult. Collection/map of records using WG's original keys; use `$result->record($key)` or `$result->data()`.

Top-level response fields: `author_id` (numeric), `created_at` (timestamp), `editor_id` (numeric), `is_read` (boolean), `message` (string), `updated_at` (timestamp).

Multiget: `prepareMessageboard()` accepts identical arguments and returns PreparedOperation without network I/O. Submit it to `executeMany()`. A paginated preparation represents one page.

<!-- example:clans/messageboard -->
```php
// Instance call
$result = $client->clans()->messageboard(
    accessToken: $token,
);
$data = $result->data();

// Static alternative; configure the corresponding client first.
$result = Clans::messageboard(
    accessToken: $token,
);
$data = $result->data();

// Prepare for multiget; instance and static alternatives (no I/O).
$operation = $client->clans()->prepareMessageboard(
    accessToken: $token,
);
$operation = Clans::prepareMessageboard(
    accessToken: $token,
);
```

### clans/memberhistory

Read an account's clan membership history.

[Official reference](https://developers.wargaming.net/reference/all/wot/clans/memberhistory/). Realms: asia, eu, na.

Signature (identical on service and static facade):

```php
Clans::memberHistory(
    int $accountId,
    string|null $language = null,
    array $fields = [],
): ApiResult;
```

| SDK argument / API parameter | Meaning | Required / SDK default | Contract constraints |
| --- | --- | --- | --- |
| `$accountId` / `account_id` | Absolute player account ID(s) in the selected realm. Provider type: `numeric`. | Required | No further bound in the reviewed contract. |
| `$language` / `language` | Response language; omission uses the client's configured language. Provider type: `string`. | Optional / `null` | values: `en`, `ru`, `pl`, `de`, `fr`, `es`, `zh-cn`, `zh-tw`, `tr`, `cs`, `th`, `vi`, `ko` |
| `$fields` / `fields` | Response field selectors; dot paths include nested fields, a leading minus excludes fields. Provider type: `string, list`. | Optional / `[]` | items/request: 100 |

**Result:** ApiResult. Map containing nested lists (often keyed by account/clan ID); use `$result->get($key)` or `$result->data()`.

Top-level response fields: `account_id` (numeric), `clan_id` (numeric), `joined_at` (timestamp), `left_at` (timestamp), `role` (string).

Multiget: `prepareMemberHistory()` accepts identical arguments and returns PreparedOperation without network I/O. Submit it to `executeMany()`. A paginated preparation represents one page.

<!-- example:clans/memberhistory -->
```php
// Instance call
$result = $client->clans()->memberHistory(
    accountId: $accountId,
);
$data = $result->data();

// Static alternative; configure the corresponding client first.
$result = Clans::memberHistory(
    accountId: $accountId,
);
$data = $result->data();

// Prepare for multiget; instance and static alternatives (no I/O).
$operation = $client->clans()->prepareMemberHistory(
    accountId: $accountId,
);
$operation = Clans::prepareMemberHistory(
    accountId: $accountId,
);
```

## clanRatings

### clanratings/types

Read clan rating definitions and supported ranking fields.

[Official reference](https://developers.wargaming.net/reference/all/wot/clanratings/types/). Realms: asia, eu, na.

Signature (identical on service and static facade):

```php
ClanRatings::types(

): ApiResult;
```

| SDK argument / API parameter | Meaning | Required / SDK default | Contract constraints |
| --- | --- | --- | --- |

**Result:** ApiResult. Collection/map of records using WG's original keys; use `$result->record($key)` or `$result->data()`.

Top-level response fields: `rank_fields` (list of strings), `type` (string).

Multiget: `prepareTypes()` accepts identical arguments and returns PreparedOperation without network I/O. Submit it to `executeMany()`. A paginated preparation represents one page.

<!-- example:clanratings/types -->
```php
// Instance call
$result = $client->clanRatings()->types();
$data = $result->data();

// Static alternative; configure the corresponding client first.
$result = ClanRatings::types();
$data = $result->data();

// Prepare for multiget; instance and static alternatives (no I/O).
$operation = $client->clanRatings()->prepareTypes();
$operation = ClanRatings::prepareTypes();
```

### clanratings/dates

Read available clan rating dates.

[Official reference](https://developers.wargaming.net/reference/all/wot/clanratings/dates/). Realms: asia, eu, na.

Signature (identical on service and static facade):

```php
ClanRatings::dates(
    int|null $limit = null,
): ApiResult;
```

| SDK argument / API parameter | Meaning | Required / SDK default | Contract constraints |
| --- | --- | --- | --- |
| `$limit` / `limit` | Maximum number of rows requested per page or response. Provider type: `numeric`. | Optional / `null` | maximum: 365 |

**Result:** ApiResult. Single object; use `$result->object()` or `$result->data()`.

Top-level response fields: `dates` (list of timestamps).

Multiget: `prepareDates()` accepts identical arguments and returns PreparedOperation without network I/O. Submit it to `executeMany()`. A paginated preparation represents one page.

<!-- example:clanratings/dates -->
```php
// Instance call
$result = $client->clanRatings()->dates(
    limit: 10,
);
$data = $result->data();

// Static alternative; configure the corresponding client first.
$result = ClanRatings::dates(
    limit: 10,
);
$data = $result->data();

// Prepare for multiget; instance and static alternatives (no I/O).
$operation = $client->clanRatings()->prepareDates(
    limit: 10,
);
$operation = ClanRatings::prepareDates(
    limit: 10,
);
```

### clanratings/clans

Read selected clans' rating positions.

[Official reference](https://developers.wargaming.net/reference/all/wot/clanratings/clans/). Realms: asia, eu, na.

Signature (identical on service and static facade):

```php
ClanRatings::clans(
    array $clanIds,
    string|null $language = null,
    array $fields = [],
    int|string|null $date = null,
): ApiResult;
```

| SDK argument / API parameter | Meaning | Required / SDK default | Contract constraints |
| --- | --- | --- | --- |
| `$clanIds` / `clan_id` | Absolute clan ID(s) in the selected realm. Provider type: `numeric, list`. | Required | items/request: 100 Required IDs are deduplicated and automatically batched at this limit. |
| `$language` / `language` | Response language; omission uses the client's configured language. Provider type: `string`. | Optional / `null` | values: `en`, `ru`, `pl`, `de`, `fr`, `es`, `zh-cn`, `zh-tw`, `tr`, `cs`, `th`, `vi`, `ko` |
| `$fields` / `fields` | Response field selectors; dot paths include nested fields, a leading minus excludes fields. Provider type: `string, list`. | Optional / `[]` | items/request: 100 |
| `$date` / `date` | Rating date; use a date returned by the corresponding dates() method. Provider type: `timestamp/date`. | Optional / `null` | No further bound in the reviewed contract. |

**Result:** ApiResult. Collection/map of records using WG's original keys; use `$result->record($key)` or `$result->data()`.

Top-level response fields: `battles_count_avg` (block_header), `battles_count_avg_daily` (block_header), `clan_id` (numeric), `clan_name` (string), `clan_tag` (string), `efficiency` (block_header), `exclude_reasons` (associative array), `fb_elo_rating` (block_header), `fb_elo_rating_10` (block_header), `fb_elo_rating_6` (block_header), `fb_elo_rating_8` (block_header), `global_rating_avg` (block_header), `global_rating_weighted_avg` (block_header), `gm_elo_rating` (block_header), `gm_elo_rating_10` (block_header), `gm_elo_rating_6` (block_header), `gm_elo_rating_8` (block_header), `rating_fort` (block_header), `v10l_avg` (block_header), `wins_ratio_avg` (block_header).

Multiget: `prepareClans()` accepts identical arguments and returns PreparedOperation without network I/O. Submit it to `executeMany()`. A paginated preparation represents one page.

<!-- example:clanratings/clans -->
```php
// Instance call
$result = $client->clanRatings()->clans(
    clanIds: [$clanId],
);
$data = $result->data();

// Static alternative; configure the corresponding client first.
$result = ClanRatings::clans(
    clanIds: [$clanId],
);
$data = $result->data();

// Prepare for multiget; instance and static alternatives (no I/O).
$operation = $client->clanRatings()->prepareClans(
    clanIds: [$clanId],
);
$operation = ClanRatings::prepareClans(
    clanIds: [$clanId],
);
```

### clanratings/neighbors

Read a clan's neighboring positions in a clan ranking.

[Official reference](https://developers.wargaming.net/reference/all/wot/clanratings/neighbors/). Realms: asia, eu, na.

Signature (identical on service and static facade):

```php
ClanRatings::neighbors(
    string $rankField,
    int $clanId,
    string|null $language = null,
    array $fields = [],
    int|string|null $date = null,
    int|null $limit = null,
): ApiResult;
```

| SDK argument / API parameter | Meaning | Required / SDK default | Contract constraints |
| --- | --- | --- | --- |
| `$rankField` / `rank_field` | Ranking field obtained from the corresponding types() response. Provider type: `string`. | Required | No further bound in the reviewed contract. |
| `$clanId` / `clan_id` | Absolute clan ID(s) in the selected realm. Provider type: `numeric`. | Required | No further bound in the reviewed contract. |
| `$language` / `language` | Response language; omission uses the client's configured language. Provider type: `string`. | Optional / `null` | values: `en`, `ru`, `pl`, `de`, `fr`, `es`, `zh-cn`, `zh-tw`, `tr`, `cs`, `th`, `vi`, `ko` |
| `$fields` / `fields` | Response field selectors; dot paths include nested fields, a leading minus excludes fields. Provider type: `string, list`. | Optional / `[]` | items/request: 100 |
| `$date` / `date` | Rating date; use a date returned by the corresponding dates() method. Provider type: `timestamp/date`. | Optional / `null` | No further bound in the reviewed contract. |
| `$limit` / `limit` | Maximum number of rows requested per page or response. Provider type: `numeric`. | Optional / `null` | maximum: 50 |

**Result:** ApiResult. Collection/map of records using WG's original keys; use `$result->record($key)` or `$result->data()`.

Top-level response fields: `battles_count_avg` (block_header), `battles_count_avg_daily` (block_header), `clan_id` (numeric), `clan_name` (string), `clan_tag` (string), `efficiency` (block_header), `exclude_reasons` (associative array), `fb_elo_rating` (block_header), `fb_elo_rating_10` (block_header), `fb_elo_rating_6` (block_header), `fb_elo_rating_8` (block_header), `global_rating_avg` (block_header), `global_rating_weighted_avg` (block_header), `gm_elo_rating` (block_header), `gm_elo_rating_10` (block_header), `gm_elo_rating_6` (block_header), `gm_elo_rating_8` (block_header), `rating_fort` (block_header), `v10l_avg` (block_header), `wins_ratio_avg` (block_header).

Multiget: `prepareNeighbors()` accepts identical arguments and returns PreparedOperation without network I/O. Submit it to `executeMany()`. A paginated preparation represents one page.

<!-- example:clanratings/neighbors -->
```php
// Instance call
$result = $client->clanRatings()->neighbors(
    rankField: $rankField,
    clanId: $clanId,
    limit: 10,
);
$data = $result->data();

// Static alternative; configure the corresponding client first.
$result = ClanRatings::neighbors(
    rankField: $rankField,
    clanId: $clanId,
    limit: 10,
);
$data = $result->data();

// Prepare for multiget; instance and static alternatives (no I/O).
$operation = $client->clanRatings()->prepareNeighbors(
    rankField: $rankField,
    clanId: $clanId,
    limit: 10,
);
$operation = ClanRatings::prepareNeighbors(
    rankField: $rankField,
    clanId: $clanId,
    limit: 10,
);
```

### clanratings/top

Read the leading clans for one ranking field.

[Official reference](https://developers.wargaming.net/reference/all/wot/clanratings/top/). Realms: asia, eu, na.

Signature (identical on service and static facade):

```php
ClanRatings::top(
    string $rankField,
    string|null $language = null,
    array $fields = [],
    int|string|null $date = null,
    int|null $pageNo = null,
    int|null $limit = null,
): ApiResult;
```

| SDK argument / API parameter | Meaning | Required / SDK default | Contract constraints |
| --- | --- | --- | --- |
| `$rankField` / `rank_field` | Ranking field obtained from the corresponding types() response. Provider type: `string`. | Required | No further bound in the reviewed contract. |
| `$language` / `language` | Response language; omission uses the client's configured language. Provider type: `string`. | Optional / `null` | values: `en`, `ru`, `pl`, `de`, `fr`, `es`, `zh-cn`, `zh-tw`, `tr`, `cs`, `th`, `vi`, `ko` |
| `$fields` / `fields` | Response field selectors; dot paths include nested fields, a leading minus excludes fields. Provider type: `string, list`. | Optional / `[]` | items/request: 100 |
| `$date` / `date` | Rating date; use a date returned by the corresponding dates() method. Provider type: `timestamp/date`. | Optional / `null` | No further bound in the reviewed contract. |
| `$pageNo` / `page_no` | One-based page number; use iterate/all helpers to traverse pages. Provider type: `numeric`. | Optional / `null` | No further bound in the reviewed contract. |
| `$limit` / `limit` | Maximum number of rows requested per page or response. Provider type: `numeric`. | Optional / `null` | maximum: 1000 |

**Result:** ApiResult. Collection/map of records using WG's original keys; use `$result->record($key)` or `$result->data()`.

Top-level response fields: `battles_count_avg` (block_header), `battles_count_avg_daily` (block_header), `clan_id` (numeric), `clan_name` (string), `clan_tag` (string), `efficiency` (block_header), `exclude_reasons` (associative array), `fb_elo_rating` (block_header), `fb_elo_rating_10` (block_header), `fb_elo_rating_6` (block_header), `fb_elo_rating_8` (block_header), `global_rating_avg` (block_header), `global_rating_weighted_avg` (block_header), `gm_elo_rating` (block_header), `gm_elo_rating_10` (block_header), `gm_elo_rating_6` (block_header), `gm_elo_rating_8` (block_header), `rating_fort` (block_header), `v10l_avg` (block_header), `wins_ratio_avg` (block_header).

Multiget: `prepareTop()` accepts identical arguments and returns PreparedOperation without network I/O. Submit it to `executeMany()`. A paginated preparation represents one page.

Pagination: `iterateTop()` returns Generator of Record/null; `allTop()` returns ApiResult. Both accept the arguments above except pageNo, plus `int $startPage = 1` and `int $maxPages = 1000`. Exhausting the bound throws; all() retains all rows in memory.

<!-- example:clanratings/top -->
```php
// Instance call
$result = $client->clanRatings()->top(
    rankField: $rankField,
    limit: 10,
);
$data = $result->data();

// Static alternative; configure the corresponding client first.
$result = ClanRatings::top(
    rankField: $rankField,
    limit: 10,
);
$data = $result->data();

// Prepare for multiget; instance and static alternatives (no I/O).
$operation = $client->clanRatings()->prepareTop(
    rankField: $rankField,
    limit: 10,
);
$operation = ClanRatings::prepareTop(
    rankField: $rankField,
    limit: 10,
);

// Lazy traversal, or collect every page in memory.
$records = $client->clanRatings()->iterateTop(
    rankField: $rankField,
    limit: 10,
    maxPages: 100,
);
foreach ($records as $key => $record) {
    $row = $record?->data();
}
$all = $client->clanRatings()->allTop(
    rankField: $rankField,
    limit: 10,
    maxPages: 100,
);

// Static pagination alternatives.
$records = ClanRatings::iterateTop(
    rankField: $rankField,
    limit: 10,
    maxPages: 100,
);
foreach ($records as $key => $record) {
    $row = $record?->data();
}
$all = ClanRatings::allTop(
    rankField: $rankField,
    limit: 10,
    maxPages: 100,
);
```

## globalMap

### globalmap/fronts

List Global Map fronts and their configuration.

[Official reference](https://developers.wargaming.net/reference/all/wot/globalmap/fronts/). Realms: asia, eu, na.

Signature (identical on service and static facade):

```php
GlobalMap::fronts(
    array $fields = [],
    string|null $language = null,
    int|null $limit = null,
    int|null $pageNo = null,
    array $frontIds = [],
): ApiResult;
```

| SDK argument / API parameter | Meaning | Required / SDK default | Contract constraints |
| --- | --- | --- | --- |
| `$fields` / `fields` | Response field selectors; dot paths include nested fields, a leading minus excludes fields. Provider type: `string, list`. | Optional / `[]` | items/request: 100 |
| `$language` / `language` | Response language; omission uses the client's configured language. Provider type: `string`. | Optional / `null` | values: `en`, `de`, `fr`, `es`, `pl`, `tr` |
| `$limit` / `limit` | Maximum number of rows requested per page or response. Provider type: `numeric`. | Optional / `null` | maximum: 100 |
| `$pageNo` / `page_no` | One-based page number; use iterate/all helpers to traverse pages. Provider type: `numeric`. | Optional / `null` | No further bound in the reviewed contract. |
| `$frontIds` / `front_id` | Front ID(s) returned by globalMap()->fronts(), compatible with the chosen event. Provider type: `string, list`. | Optional / `[]` | items/request: 100 |

**Result:** ApiResult. Collection/map of records using WG's original keys; use `$result->record($key)` or `$result->data()`.

Top-level response fields: `available_extensions` (block_header), `avg_clans_rating` (numeric), `avg_min_bet` (numeric), `avg_won_bet` (numeric), `battle_time_limit` (numeric), `division_cost` (numeric), `fog_of_war` (boolean), `front_id` (string), `front_name` (string), `is_active` (boolean), `is_event` (boolean), `max_tanks_per_division` (numeric), `max_vehicle_level` (numeric), `min_tanks_per_division` (numeric), `min_vehicle_level` (numeric), `provinces_count` (numeric), `vehicle_freeze` (boolean).

Multiget: `prepareFronts()` accepts identical arguments and returns PreparedOperation without network I/O. Submit it to `executeMany()`. A paginated preparation represents one page.

Pagination: `iterateFronts()` returns Generator of Record/null; `allFronts()` returns ApiResult. Both accept the arguments above except pageNo, plus `int $startPage = 1` and `int $maxPages = 1000`. Exhausting the bound throws; all() retains all rows in memory.

<!-- example:globalmap/fronts -->
```php
// Instance call
$result = $client->globalMap()->fronts(
    limit: 10,
);
$data = $result->data();

// Static alternative; configure the corresponding client first.
$result = GlobalMap::fronts(
    limit: 10,
);
$data = $result->data();

// Prepare for multiget; instance and static alternatives (no I/O).
$operation = $client->globalMap()->prepareFronts(
    limit: 10,
);
$operation = GlobalMap::prepareFronts(
    limit: 10,
);

// Lazy traversal, or collect every page in memory.
$records = $client->globalMap()->iterateFronts(
    limit: 10,
    maxPages: 100,
);
foreach ($records as $key => $record) {
    $row = $record?->data();
}
$all = $client->globalMap()->allFronts(
    limit: 10,
    maxPages: 100,
);

// Static pagination alternatives.
$records = GlobalMap::iterateFronts(
    limit: 10,
    maxPages: 100,
);
foreach ($records as $key => $record) {
    $row = $record?->data();
}
$all = GlobalMap::allFronts(
    limit: 10,
    maxPages: 100,
);
```

### globalmap/provinces

List provinces of one Global Map front using optional filters.

[Official reference](https://developers.wargaming.net/reference/all/wot/globalmap/provinces/). Realms: asia, eu, na.

Signature (identical on service and static facade):

```php
GlobalMap::provinces(
    string $frontId,
    array $fields = [],
    string|null $language = null,
    int|null $limit = null,
    int|null $pageNo = null,
    int|null $primeHour = null,
    string|null $landingType = null,
    string|null $arenaId = null,
    int|null $dailyRevenueLte = null,
    int|null $dailyRevenueGte = null,
    string|null $orderBy = null,
    array $provinceIds = [],
): ApiResult;
```

| SDK argument / API parameter | Meaning | Required / SDK default | Contract constraints |
| --- | --- | --- | --- |
| `$frontId` / `front_id` | Front ID(s) returned by globalMap()->fronts(), compatible with the chosen event. Provider type: `string`. | Required | No further bound in the reviewed contract. |
| `$fields` / `fields` | Response field selectors; dot paths include nested fields, a leading minus excludes fields. Provider type: `string, list`. | Optional / `[]` | items/request: 100 |
| `$language` / `language` | Response language; omission uses the client's configured language. Provider type: `string`. | Optional / `null` | values: `en`, `de`, `fr`, `es`, `pl`, `tr` |
| `$limit` / `limit` | Maximum number of rows requested per page or response. Provider type: `numeric`. | Optional / `null` | maximum: 100 |
| `$pageNo` / `page_no` | One-based page number; use iterate/all helpers to traverse pages. Provider type: `numeric`. | Optional / `null` | No further bound in the reviewed contract. |
| `$primeHour` / `prime_hour` | Province prime-time hour filter. Provider type: `numeric`. | Optional / `null` | maximum: 23 |
| `$landingType` / `landing_type` | Province landing category filter. Provider type: `string`. | Optional / `null` | values: `null`, `auction`, `tournament` |
| `$arenaId` / `arena_id` | Arena ID filter from encyclopedia/arenas. Provider type: `string`. | Optional / `null` | No further bound in the reviewed contract. |
| `$dailyRevenueLte` / `daily_revenue_lte` | Maximum province daily revenue. Provider type: `numeric`. | Optional / `null` | No further bound in the reviewed contract. |
| `$dailyRevenueGte` / `daily_revenue_gte` | Minimum province daily revenue. Provider type: `numeric`. | Optional / `null` | No further bound in the reviewed contract. |
| `$orderBy` / `order_by` | Provider sort order. Provider type: `string`. | Optional / `null` | values: `province_id`, `-province_id`, `daily_revenue`, `-daily_revenue`, `prime_hour`, `-prime_hour` |
| `$provinceIds` / `province_id` | Province ID filter from globalMap()->provinces(). Provider type: `string, list`. | Optional / `[]` | items/request: 100 |

**Result:** ApiResult. Collection/map of records using WG's original keys; use `$result->record($key)` or `$result->data()`.

Top-level response fields: `active_battles` (block_header), `arena_id` (string), `arena_name` (string), `attackers` (list of integers), `battles_start_at` (string), `competitors` (list of integers), `current_min_bet` (numeric), `daily_revenue` (numeric), `front_id` (string), `front_name` (string), `is_borders_disabled` (boolean), `landing_type` (string), `last_won_bet` (numeric), `max_bets` (numeric), `neighbours` (list of strings), `owner_clan_id` (numeric), `pillage_end_at` (string), `prime_time` (string), `province_id` (string), `province_name` (string), `revenue_level` (numeric), `round_number` (numeric), `server` (string), `status` (string), `uri` (string), `world_redivision` (boolean).

Multiget: `prepareProvinces()` accepts identical arguments and returns PreparedOperation without network I/O. Submit it to `executeMany()`. A paginated preparation represents one page.

Pagination: `iterateProvinces()` returns Generator of Record/null; `allProvinces()` returns ApiResult. Both accept the arguments above except pageNo, plus `int $startPage = 1` and `int $maxPages = 1000`. Exhausting the bound throws; all() retains all rows in memory.

<!-- example:globalmap/provinces -->
```php
// Instance call
$result = $client->globalMap()->provinces(
    frontId: $frontId,
    limit: 10,
);
$data = $result->data();

// Static alternative; configure the corresponding client first.
$result = GlobalMap::provinces(
    frontId: $frontId,
    limit: 10,
);
$data = $result->data();

// Prepare for multiget; instance and static alternatives (no I/O).
$operation = $client->globalMap()->prepareProvinces(
    frontId: $frontId,
    limit: 10,
);
$operation = GlobalMap::prepareProvinces(
    frontId: $frontId,
    limit: 10,
);

// Lazy traversal, or collect every page in memory.
$records = $client->globalMap()->iterateProvinces(
    frontId: $frontId,
    limit: 10,
    maxPages: 100,
);
foreach ($records as $key => $record) {
    $row = $record?->data();
}
$all = $client->globalMap()->allProvinces(
    frontId: $frontId,
    limit: 10,
    maxPages: 100,
);

// Static pagination alternatives.
$records = GlobalMap::iterateProvinces(
    frontId: $frontId,
    limit: 10,
    maxPages: 100,
);
foreach ($records as $key => $record) {
    $row = $record?->data();
}
$all = GlobalMap::allProvinces(
    frontId: $frontId,
    limit: 10,
    maxPages: 100,
);
```

### globalmap/claninfo

Read Global Map information and statistics for selected clans.

[Official reference](https://developers.wargaming.net/reference/all/wot/globalmap/claninfo/). Realms: asia, eu, na.

Signature (identical on service and static facade):

```php
GlobalMap::clanInfo(
    array $clanIds,
    array $fields = [],
    AccessToken|null $accessToken = null,
): ApiResult;
```

| SDK argument / API parameter | Meaning | Required / SDK default | Contract constraints |
| --- | --- | --- | --- |
| `$clanIds` / `clan_id` | Absolute clan ID(s) in the selected realm. Provider type: `numeric, list`. | Required | items/request: 10 Required IDs are deduplicated and automatically batched at this limit. |
| `$fields` / `fields` | Response field selectors; dot paths include nested fields, a leading minus excludes fields. Provider type: `string, list`. | Optional / `[]` | items/request: 100 |
| `$accessToken` / `access_token` | Verified, unexpired WgAuth token for the selected realm. Provider type: `string`. | Optional / `null` | No further bound in the reviewed contract. |

**Result:** ApiResult. Collection/map of records using WG's original keys; use `$result->record($key)` or `$result->data()`.

Top-level response fields: `clan_id` (numeric), `name` (string), `private` (block_header), `ratings` (block_header), `statistics` (block_header), `tag` (string).

Multiget: `prepareClanInfo()` accepts identical arguments and returns PreparedOperation without network I/O. Submit it to `executeMany()`. A paginated preparation represents one page.

<!-- example:globalmap/claninfo -->
```php
// Instance call
$result = $client->globalMap()->clanInfo(
    clanIds: [$clanId],
);
$data = $result->data();

// Static alternative; configure the corresponding client first.
$result = GlobalMap::clanInfo(
    clanIds: [$clanId],
);
$data = $result->data();

// Prepare for multiget; instance and static alternatives (no I/O).
$operation = $client->globalMap()->prepareClanInfo(
    clanIds: [$clanId],
);
$operation = GlobalMap::prepareClanInfo(
    clanIds: [$clanId],
);
```

### globalmap/clanprovinces

Read provinces held by each selected clan.

[Official reference](https://developers.wargaming.net/reference/all/wot/globalmap/clanprovinces/). Realms: asia, eu, na.

Signature (identical on service and static facade):

```php
GlobalMap::clanProvinces(
    array $clanIds,
    array $fields = [],
    AccessToken|null $accessToken = null,
    string|null $language = null,
): ApiResult;
```

| SDK argument / API parameter | Meaning | Required / SDK default | Contract constraints |
| --- | --- | --- | --- |
| `$clanIds` / `clan_id` | Absolute clan ID(s) in the selected realm. Provider type: `numeric, list`. | Required | items/request: 10 Required IDs are deduplicated and automatically batched at this limit. |
| `$fields` / `fields` | Response field selectors; dot paths include nested fields, a leading minus excludes fields. Provider type: `string, list`. | Optional / `[]` | items/request: 100 |
| `$accessToken` / `access_token` | Verified, unexpired WgAuth token for the selected realm. Provider type: `string`. | Optional / `null` | No further bound in the reviewed contract. |
| `$language` / `language` | Response language; omission uses the client's configured language. Provider type: `string`. | Optional / `null` | values: `en`, `de`, `fr`, `es`, `pl`, `tr` |

**Result:** ApiResult. Map containing nested lists (often keyed by account/clan ID); use `$result->get($key)` or `$result->data()`.

Top-level response fields: `arena_id` (string), `arena_name` (string), `clan_id` (numeric), `daily_revenue` (numeric), `front_id` (string), `front_name` (string), `landing_type` (string), `max_vehicle_level` (numeric), `pillage_end_at` (string), `prime_time` (string), `private` (block_header), `province_id` (string), `province_name` (string), `revenue_level` (numeric), `turns_owned` (numeric).

Multiget: `prepareClanProvinces()` accepts identical arguments and returns PreparedOperation without network I/O. Submit it to `executeMany()`. A paginated preparation represents one page.

<!-- example:globalmap/clanprovinces -->
```php
// Instance call
$result = $client->globalMap()->clanProvinces(
    clanIds: [$clanId],
);
$data = $result->data();

// Static alternative; configure the corresponding client first.
$result = GlobalMap::clanProvinces(
    clanIds: [$clanId],
);
$data = $result->data();

// Prepare for multiget; instance and static alternatives (no I/O).
$operation = $client->globalMap()->prepareClanProvinces(
    clanIds: [$clanId],
);
$operation = GlobalMap::prepareClanProvinces(
    clanIds: [$clanId],
);
```

### globalmap/clanbattles

Read scheduled Global Map battles for a clan.

[Official reference](https://developers.wargaming.net/reference/all/wot/globalmap/clanbattles/). Realms: asia, eu, na.

Signature (identical on service and static facade):

```php
GlobalMap::clanBattles(
    int $clanId,
    array $fields = [],
    string|null $language = null,
    int|null $limit = null,
    int|null $pageNo = null,
): ApiResult;
```

| SDK argument / API parameter | Meaning | Required / SDK default | Contract constraints |
| --- | --- | --- | --- |
| `$clanId` / `clan_id` | Absolute clan ID(s) in the selected realm. Provider type: `numeric`. | Required | No further bound in the reviewed contract. |
| `$fields` / `fields` | Response field selectors; dot paths include nested fields, a leading minus excludes fields. Provider type: `string, list`. | Optional / `[]` | items/request: 100 |
| `$language` / `language` | Response language; omission uses the client's configured language. Provider type: `string`. | Optional / `null` | values: `en`, `de`, `fr`, `es`, `pl`, `tr` |
| `$limit` / `limit` | Maximum number of rows requested per page or response. Provider type: `numeric`. | Optional / `null` | maximum: 100 |
| `$pageNo` / `page_no` | One-based page number; use iterate/all helpers to traverse pages. Provider type: `numeric`. | Optional / `null` | No further bound in the reviewed contract. |

**Result:** ApiResult. Collection/map of records using WG's original keys; use `$result->record($key)` or `$result->data()`.

Top-level response fields: `attack_type` (string), `competitor_id` (numeric), `front_id` (string), `front_name` (string), `province_id` (string), `province_name` (string), `time` (timestamp), `type` (string), `vehicle_level` (numeric).

Multiget: `prepareClanBattles()` accepts identical arguments and returns PreparedOperation without network I/O. Submit it to `executeMany()`. A paginated preparation represents one page.

Pagination: `iterateClanBattles()` returns Generator of Record/null; `allClanBattles()` returns ApiResult. Both accept the arguments above except pageNo, plus `int $startPage = 1` and `int $maxPages = 1000`. Exhausting the bound throws; all() retains all rows in memory.

<!-- example:globalmap/clanbattles -->
```php
// Instance call
$result = $client->globalMap()->clanBattles(
    clanId: $clanId,
    limit: 10,
);
$data = $result->data();

// Static alternative; configure the corresponding client first.
$result = GlobalMap::clanBattles(
    clanId: $clanId,
    limit: 10,
);
$data = $result->data();

// Prepare for multiget; instance and static alternatives (no I/O).
$operation = $client->globalMap()->prepareClanBattles(
    clanId: $clanId,
    limit: 10,
);
$operation = GlobalMap::prepareClanBattles(
    clanId: $clanId,
    limit: 10,
);

// Lazy traversal, or collect every page in memory.
$records = $client->globalMap()->iterateClanBattles(
    clanId: $clanId,
    limit: 10,
    maxPages: 100,
);
foreach ($records as $key => $record) {
    $row = $record?->data();
}
$all = $client->globalMap()->allClanBattles(
    clanId: $clanId,
    limit: 10,
    maxPages: 100,
);

// Static pagination alternatives.
$records = GlobalMap::iterateClanBattles(
    clanId: $clanId,
    limit: 10,
    maxPages: 100,
);
foreach ($records as $key => $record) {
    $row = $record?->data();
}
$all = GlobalMap::allClanBattles(
    clanId: $clanId,
    limit: 10,
    maxPages: 100,
);
```

### globalmap/seasons

List Global Map seasons.

[Official reference](https://developers.wargaming.net/reference/all/wot/globalmap/seasons/). Realms: asia, eu, na.

Signature (identical on service and static facade):

```php
GlobalMap::seasons(
    array $fields = [],
    string|null $language = null,
    int|null $pageNo = null,
    string|null $seasonId = null,
    int|null $limit = null,
    string|null $status = null,
): ApiResult;
```

| SDK argument / API parameter | Meaning | Required / SDK default | Contract constraints |
| --- | --- | --- | --- |
| `$fields` / `fields` | Response field selectors; dot paths include nested fields, a leading minus excludes fields. Provider type: `string, list`. | Optional / `[]` | items/request: 100 |
| `$language` / `language` | Response language; omission uses the client's configured language. Provider type: `string`. | Optional / `null` | values: `en`, `de`, `fr`, `es`, `pl`, `tr` |
| `$pageNo` / `page_no` | One-based page number; use iterate/all helpers to traverse pages. Provider type: `numeric`. | Optional / `null` | No further bound in the reviewed contract. |
| `$seasonId` / `season_id` | Season ID returned by globalMap()->seasons(). Provider type: `string`. | Optional / `null` | No further bound in the reviewed contract. |
| `$limit` / `limit` | Maximum number of rows requested per page or response. Provider type: `numeric`. | Optional / `null` | maximum: 20 |
| `$status` / `status` | Provider status filter. Provider type: `string`. | Optional / `null` | values: `PLANNED`, `ACTIVE`, `FINISHED` |

**Result:** ApiResult. Collection/map of records using WG's original keys; use `$result->record($key)` or `$result->data()`.

Top-level response fields: `end` (string), `fronts` (block_header), `season_id` (string), `season_name` (string), `start` (string), `status` (string).

Multiget: `prepareSeasons()` accepts identical arguments and returns PreparedOperation without network I/O. Submit it to `executeMany()`. A paginated preparation represents one page.

Pagination: `iterateSeasons()` returns Generator of Record/null; `allSeasons()` returns ApiResult. Both accept the arguments above except pageNo, plus `int $startPage = 1` and `int $maxPages = 1000`. Exhausting the bound throws; all() retains all rows in memory.

<!-- example:globalmap/seasons -->
```php
// Instance call
$result = $client->globalMap()->seasons(
    limit: 10,
);
$data = $result->data();

// Static alternative; configure the corresponding client first.
$result = GlobalMap::seasons(
    limit: 10,
);
$data = $result->data();

// Prepare for multiget; instance and static alternatives (no I/O).
$operation = $client->globalMap()->prepareSeasons(
    limit: 10,
);
$operation = GlobalMap::prepareSeasons(
    limit: 10,
);

// Lazy traversal, or collect every page in memory.
$records = $client->globalMap()->iterateSeasons(
    limit: 10,
    maxPages: 100,
);
foreach ($records as $key => $record) {
    $row = $record?->data();
}
$all = $client->globalMap()->allSeasons(
    limit: 10,
    maxPages: 100,
);

// Static pagination alternatives.
$records = GlobalMap::iterateSeasons(
    limit: 10,
    maxPages: 100,
);
foreach ($records as $key => $record) {
    $row = $record?->data();
}
$all = GlobalMap::allSeasons(
    limit: 10,
    maxPages: 100,
);
```

### globalmap/seasonclaninfo

Read a clan's season results for selected vehicle levels.

[Official reference](https://developers.wargaming.net/reference/all/wot/globalmap/seasonclaninfo/). Realms: asia, eu, na.

Signature (identical on service and static facade):

```php
GlobalMap::seasonClanInfo(
    string $seasonId,
    array $vehicleLevel,
    int $clanId,
    array $fields = [],
): ApiResult;
```

| SDK argument / API parameter | Meaning | Required / SDK default | Contract constraints |
| --- | --- | --- | --- |
| `$seasonId` / `season_id` | Season ID returned by globalMap()->seasons(). Provider type: `string`. | Required | No further bound in the reviewed contract. |
| `$vehicleLevel` / `vehicle_level` | Vehicle level(s) used by the selected Global Map season. Provider type: `string, list`. | Required | items/request: 100; values: `6`, `8`, `10` |
| `$clanId` / `clan_id` | Absolute clan ID(s) in the selected realm. Provider type: `numeric`. | Required | No further bound in the reviewed contract. |
| `$fields` / `fields` | Response field selectors; dot paths include nested fields, a leading minus excludes fields. Provider type: `string, list`. | Optional / `[]` | items/request: 100 |

**Result:** ApiResult. Collection/map of records using WG's original keys; use `$result->record($key)` or `$result->data()`.

Top-level response fields: `seasons` (block_header).

Multiget: `prepareSeasonClanInfo()` accepts identical arguments and returns PreparedOperation without network I/O. Submit it to `executeMany()`. A paginated preparation represents one page.

<!-- example:globalmap/seasonclaninfo -->
```php
// Instance call
$result = $client->globalMap()->seasonClanInfo(
    seasonId: $seasonId,
    vehicleLevel: ['10'],
    clanId: $clanId,
);
$data = $result->data();

// Static alternative; configure the corresponding client first.
$result = GlobalMap::seasonClanInfo(
    seasonId: $seasonId,
    vehicleLevel: ['10'],
    clanId: $clanId,
);
$data = $result->data();

// Prepare for multiget; instance and static alternatives (no I/O).
$operation = $client->globalMap()->prepareSeasonClanInfo(
    seasonId: $seasonId,
    vehicleLevel: ['10'],
    clanId: $clanId,
);
$operation = GlobalMap::prepareSeasonClanInfo(
    seasonId: $seasonId,
    vehicleLevel: ['10'],
    clanId: $clanId,
);
```

### globalmap/seasonaccountinfo

Read a player's season results for selected vehicle levels.

[Official reference](https://developers.wargaming.net/reference/all/wot/globalmap/seasonaccountinfo/). Realms: asia, eu, na.

Signature (identical on service and static facade):

```php
GlobalMap::seasonAccountInfo(
    string $seasonId,
    array $vehicleLevel,
    int $accountId,
    array $fields = [],
): ApiResult;
```

| SDK argument / API parameter | Meaning | Required / SDK default | Contract constraints |
| --- | --- | --- | --- |
| `$seasonId` / `season_id` | Season ID returned by globalMap()->seasons(). Provider type: `string`. | Required | No further bound in the reviewed contract. |
| `$vehicleLevel` / `vehicle_level` | Vehicle level(s) used by the selected Global Map season. Provider type: `string, list`. | Required | items/request: 100; values: `6`, `8`, `10` |
| `$accountId` / `account_id` | Absolute player account ID(s) in the selected realm. Provider type: `numeric`. | Required | No further bound in the reviewed contract. |
| `$fields` / `fields` | Response field selectors; dot paths include nested fields, a leading minus excludes fields. Provider type: `string, list`. | Optional / `[]` | items/request: 100 |

**Result:** ApiResult. Collection/map of records using WG's original keys; use `$result->record($key)` or `$result->data()`.

Top-level response fields: `seasons` (block_header).

Multiget: `prepareSeasonAccountInfo()` accepts identical arguments and returns PreparedOperation without network I/O. Submit it to `executeMany()`. A paginated preparation represents one page.

<!-- example:globalmap/seasonaccountinfo -->
```php
// Instance call
$result = $client->globalMap()->seasonAccountInfo(
    seasonId: $seasonId,
    vehicleLevel: ['10'],
    accountId: $accountId,
);
$data = $result->data();

// Static alternative; configure the corresponding client first.
$result = GlobalMap::seasonAccountInfo(
    seasonId: $seasonId,
    vehicleLevel: ['10'],
    accountId: $accountId,
);
$data = $result->data();

// Prepare for multiget; instance and static alternatives (no I/O).
$operation = $client->globalMap()->prepareSeasonAccountInfo(
    seasonId: $seasonId,
    vehicleLevel: ['10'],
    accountId: $accountId,
);
$operation = GlobalMap::prepareSeasonAccountInfo(
    seasonId: $seasonId,
    vehicleLevel: ['10'],
    accountId: $accountId,
);
```

### globalmap/seasonrating

Read the clan ranking for a season and vehicle level.

[Official reference](https://developers.wargaming.net/reference/all/wot/globalmap/seasonrating/). Realms: asia, eu, na.

Signature (identical on service and static facade):

```php
GlobalMap::seasonRating(
    string $seasonId,
    string $vehicleLevel,
    array $fields = [],
    int|null $pageNo = null,
    int|null $limit = null,
): ApiResult;
```

| SDK argument / API parameter | Meaning | Required / SDK default | Contract constraints |
| --- | --- | --- | --- |
| `$seasonId` / `season_id` | Season ID returned by globalMap()->seasons(). Provider type: `string`. | Required | No further bound in the reviewed contract. |
| `$vehicleLevel` / `vehicle_level` | Vehicle level(s) used by the selected Global Map season. Provider type: `string`. | Required | values: `6`, `8`, `10` |
| `$fields` / `fields` | Response field selectors; dot paths include nested fields, a leading minus excludes fields. Provider type: `string, list`. | Optional / `[]` | items/request: 100 |
| `$pageNo` / `page_no` | One-based page number; use iterate/all helpers to traverse pages. Provider type: `numeric`. | Optional / `null` | No further bound in the reviewed contract. |
| `$limit` / `limit` | Maximum number of rows requested per page or response. Provider type: `numeric`. | Optional / `null` | maximum: 100 |

**Result:** ApiResult. Collection/map of records using WG's original keys; use `$result->record($key)` or `$result->data()`.

Top-level response fields: `award_level` (string), `clan_id` (numeric), `color` (string), `name` (string), `rank` (numeric), `rank_delta` (numeric), `tag` (string), `updated_at` (timestamp), `victory_points` (numeric), `victory_points_to_next_award` (numeric).

Multiget: `prepareSeasonRating()` accepts identical arguments and returns PreparedOperation without network I/O. Submit it to `executeMany()`. A paginated preparation represents one page.

Pagination: `iterateSeasonRating()` returns Generator of Record/null; `allSeasonRating()` returns ApiResult. Both accept the arguments above except pageNo, plus `int $startPage = 1` and `int $maxPages = 1000`. Exhausting the bound throws; all() retains all rows in memory.

<!-- example:globalmap/seasonrating -->
```php
// Instance call
$result = $client->globalMap()->seasonRating(
    seasonId: $seasonId,
    vehicleLevel: '10',
    limit: 10,
);
$data = $result->data();

// Static alternative; configure the corresponding client first.
$result = GlobalMap::seasonRating(
    seasonId: $seasonId,
    vehicleLevel: '10',
    limit: 10,
);
$data = $result->data();

// Prepare for multiget; instance and static alternatives (no I/O).
$operation = $client->globalMap()->prepareSeasonRating(
    seasonId: $seasonId,
    vehicleLevel: '10',
    limit: 10,
);
$operation = GlobalMap::prepareSeasonRating(
    seasonId: $seasonId,
    vehicleLevel: '10',
    limit: 10,
);

// Lazy traversal, or collect every page in memory.
$records = $client->globalMap()->iterateSeasonRating(
    seasonId: $seasonId,
    vehicleLevel: '10',
    limit: 10,
    maxPages: 100,
);
foreach ($records as $key => $record) {
    $row = $record?->data();
}
$all = $client->globalMap()->allSeasonRating(
    seasonId: $seasonId,
    vehicleLevel: '10',
    limit: 10,
    maxPages: 100,
);

// Static pagination alternatives.
$records = GlobalMap::iterateSeasonRating(
    seasonId: $seasonId,
    vehicleLevel: '10',
    limit: 10,
    maxPages: 100,
);
foreach ($records as $key => $record) {
    $row = $record?->data();
}
$all = GlobalMap::allSeasonRating(
    seasonId: $seasonId,
    vehicleLevel: '10',
    limit: 10,
    maxPages: 100,
);
```

### globalmap/seasonratingneighbors

Read a clan's neighboring ranks in a season ranking.

[Official reference](https://developers.wargaming.net/reference/all/wot/globalmap/seasonratingneighbors/). Realms: asia, eu, na.

Signature (identical on service and static facade):

```php
GlobalMap::seasonRatingNeighbors(
    string $seasonId,
    string $vehicleLevel,
    int $clanId,
    array $fields = [],
    int|null $limit = null,
): ApiResult;
```

| SDK argument / API parameter | Meaning | Required / SDK default | Contract constraints |
| --- | --- | --- | --- |
| `$seasonId` / `season_id` | Season ID returned by globalMap()->seasons(). Provider type: `string`. | Required | No further bound in the reviewed contract. |
| `$vehicleLevel` / `vehicle_level` | Vehicle level(s) used by the selected Global Map season. Provider type: `string`. | Required | values: `6`, `8`, `10` |
| `$clanId` / `clan_id` | Absolute clan ID(s) in the selected realm. Provider type: `numeric`. | Required | No further bound in the reviewed contract. |
| `$fields` / `fields` | Response field selectors; dot paths include nested fields, a leading minus excludes fields. Provider type: `string, list`. | Optional / `[]` | items/request: 100 |
| `$limit` / `limit` | Maximum number of rows requested per page or response. Provider type: `numeric`. | Optional / `null` | maximum: 99 |

**Result:** ApiResult. Collection/map of records using WG's original keys; use `$result->record($key)` or `$result->data()`.

Top-level response fields: `award_level` (string), `clan_id` (numeric), `color` (string), `name` (string), `rank` (numeric), `rank_delta` (numeric), `tag` (string), `updated_at` (timestamp), `victory_points` (numeric), `victory_points_to_next_award` (numeric).

Multiget: `prepareSeasonRatingNeighbors()` accepts identical arguments and returns PreparedOperation without network I/O. Submit it to `executeMany()`. A paginated preparation represents one page.

<!-- example:globalmap/seasonratingneighbors -->
```php
// Instance call
$result = $client->globalMap()->seasonRatingNeighbors(
    seasonId: $seasonId,
    vehicleLevel: '10',
    clanId: $clanId,
    limit: 10,
);
$data = $result->data();

// Static alternative; configure the corresponding client first.
$result = GlobalMap::seasonRatingNeighbors(
    seasonId: $seasonId,
    vehicleLevel: '10',
    clanId: $clanId,
    limit: 10,
);
$data = $result->data();

// Prepare for multiget; instance and static alternatives (no I/O).
$operation = $client->globalMap()->prepareSeasonRatingNeighbors(
    seasonId: $seasonId,
    vehicleLevel: '10',
    clanId: $clanId,
    limit: 10,
);
$operation = GlobalMap::prepareSeasonRatingNeighbors(
    seasonId: $seasonId,
    vehicleLevel: '10',
    clanId: $clanId,
    limit: 10,
);
```

### globalmap/events

List Global Map events.

[Official reference](https://developers.wargaming.net/reference/all/wot/globalmap/events/). Realms: asia, eu, na.

Signature (identical on service and static facade):

```php
GlobalMap::events(
    array $fields = [],
    string|null $language = null,
    int|null $pageNo = null,
    string|null $eventId = null,
    int|null $limit = null,
    string|null $status = null,
): ApiResult;
```

| SDK argument / API parameter | Meaning | Required / SDK default | Contract constraints |
| --- | --- | --- | --- |
| `$fields` / `fields` | Response field selectors; dot paths include nested fields, a leading minus excludes fields. Provider type: `string, list`. | Optional / `[]` | items/request: 100 |
| `$language` / `language` | Response language; omission uses the client's configured language. Provider type: `string`. | Optional / `null` | values: `en`, `de`, `fr`, `es`, `pl`, `tr` |
| `$pageNo` / `page_no` | One-based page number; use iterate/all helpers to traverse pages. Provider type: `numeric`. | Optional / `null` | No further bound in the reviewed contract. |
| `$eventId` / `event_id` | Event ID returned by globalMap()->events(). Provider type: `string`. | Optional / `null` | No further bound in the reviewed contract. |
| `$limit` / `limit` | Maximum number of rows requested per page or response. Provider type: `numeric`. | Optional / `null` | maximum: 20 |
| `$status` / `status` | Provider status filter. Provider type: `string`. | Optional / `null` | values: `PLANNED`, `ACTIVE`, `FINISHED` |

**Result:** ApiResult. Collection/map of records using WG's original keys; use `$result->record($key)` or `$result->data()`.

Top-level response fields: `end` (string), `event_id` (string), `event_name` (string), `fronts` (block_header), `start` (string), `status` (string).

Multiget: `prepareEvents()` accepts identical arguments and returns PreparedOperation without network I/O. Submit it to `executeMany()`. A paginated preparation represents one page.

Pagination: `iterateEvents()` returns Generator of Record/null; `allEvents()` returns ApiResult. Both accept the arguments above except pageNo, plus `int $startPage = 1` and `int $maxPages = 1000`. Exhausting the bound throws; all() retains all rows in memory.

<!-- example:globalmap/events -->
```php
// Instance call
$result = $client->globalMap()->events(
    limit: 10,
);
$data = $result->data();

// Static alternative; configure the corresponding client first.
$result = GlobalMap::events(
    limit: 10,
);
$data = $result->data();

// Prepare for multiget; instance and static alternatives (no I/O).
$operation = $client->globalMap()->prepareEvents(
    limit: 10,
);
$operation = GlobalMap::prepareEvents(
    limit: 10,
);

// Lazy traversal, or collect every page in memory.
$records = $client->globalMap()->iterateEvents(
    limit: 10,
    maxPages: 100,
);
foreach ($records as $key => $record) {
    $row = $record?->data();
}
$all = $client->globalMap()->allEvents(
    limit: 10,
    maxPages: 100,
);

// Static pagination alternatives.
$records = GlobalMap::iterateEvents(
    limit: 10,
    maxPages: 100,
);
foreach ($records as $key => $record) {
    $row = $record?->data();
}
$all = GlobalMap::allEvents(
    limit: 10,
    maxPages: 100,
);
```

### globalmap/eventclaninfo

Read a clan's event results for selected fronts.

[Official reference](https://developers.wargaming.net/reference/all/wot/globalmap/eventclaninfo/). Realms: asia, eu, na.

Signature (identical on service and static facade):

```php
GlobalMap::eventClanInfo(
    string $eventId,
    array $frontIds,
    int $clanId,
    array $fields = [],
): ApiResult;
```

| SDK argument / API parameter | Meaning | Required / SDK default | Contract constraints |
| --- | --- | --- | --- |
| `$eventId` / `event_id` | Event ID returned by globalMap()->events(). Provider type: `string`. | Required | No further bound in the reviewed contract. |
| `$frontIds` / `front_id` | Front ID(s) returned by globalMap()->fronts(), compatible with the chosen event. Provider type: `string, list`. | Required | items/request: 10 |
| `$clanId` / `clan_id` | Absolute clan ID(s) in the selected realm. Provider type: `numeric`. | Required | No further bound in the reviewed contract. |
| `$fields` / `fields` | Response field selectors; dot paths include nested fields, a leading minus excludes fields. Provider type: `string, list`. | Optional / `[]` | items/request: 100 |

**Result:** ApiResult. Collection/map of records using WG's original keys; use `$result->record($key)` or `$result->data()`.

Top-level response fields: `events` (block_header).

Multiget: `prepareEventClanInfo()` accepts identical arguments and returns PreparedOperation without network I/O. Submit it to `executeMany()`. A paginated preparation represents one page.

<!-- example:globalmap/eventclaninfo -->
```php
// Instance call
$result = $client->globalMap()->eventClanInfo(
    eventId: $eventId,
    frontIds: [$frontId],
    clanId: $clanId,
);
$data = $result->data();

// Static alternative; configure the corresponding client first.
$result = GlobalMap::eventClanInfo(
    eventId: $eventId,
    frontIds: [$frontId],
    clanId: $clanId,
);
$data = $result->data();

// Prepare for multiget; instance and static alternatives (no I/O).
$operation = $client->globalMap()->prepareEventClanInfo(
    eventId: $eventId,
    frontIds: [$frontId],
    clanId: $clanId,
);
$operation = GlobalMap::prepareEventClanInfo(
    eventId: $eventId,
    frontIds: [$frontId],
    clanId: $clanId,
);
```

### globalmap/eventaccountinfo

Read a player's event results for selected fronts.

[Official reference](https://developers.wargaming.net/reference/all/wot/globalmap/eventaccountinfo/). Realms: asia, eu, na.

Signature (identical on service and static facade):

```php
GlobalMap::eventAccountInfo(
    string $eventId,
    array $frontIds,
    int $accountId,
    array $fields = [],
    int|null $clanId = null,
): ApiResult;
```

| SDK argument / API parameter | Meaning | Required / SDK default | Contract constraints |
| --- | --- | --- | --- |
| `$eventId` / `event_id` | Event ID returned by globalMap()->events(). Provider type: `string`. | Required | No further bound in the reviewed contract. |
| `$frontIds` / `front_id` | Front ID(s) returned by globalMap()->fronts(), compatible with the chosen event. Provider type: `string, list`. | Required | items/request: 10 |
| `$accountId` / `account_id` | Absolute player account ID(s) in the selected realm. Provider type: `numeric`. | Required | No further bound in the reviewed contract. |
| `$fields` / `fields` | Response field selectors; dot paths include nested fields, a leading minus excludes fields. Provider type: `string, list`. | Optional / `[]` | items/request: 100 |
| `$clanId` / `clan_id` | Absolute clan ID(s) in the selected realm. Provider type: `numeric`. | Optional / `null` | No further bound in the reviewed contract. |

**Result:** ApiResult. Collection/map of records using WG's original keys; use `$result->record($key)` or `$result->data()`.

Top-level response fields: `events` (block_header).

Multiget: `prepareEventAccountInfo()` accepts identical arguments and returns PreparedOperation without network I/O. Submit it to `executeMany()`. A paginated preparation represents one page.

<!-- example:globalmap/eventaccountinfo -->
```php
// Instance call
$result = $client->globalMap()->eventAccountInfo(
    eventId: $eventId,
    frontIds: [$frontId],
    accountId: $accountId,
);
$data = $result->data();

// Static alternative; configure the corresponding client first.
$result = GlobalMap::eventAccountInfo(
    eventId: $eventId,
    frontIds: [$frontId],
    accountId: $accountId,
);
$data = $result->data();

// Prepare for multiget; instance and static alternatives (no I/O).
$operation = $client->globalMap()->prepareEventAccountInfo(
    eventId: $eventId,
    frontIds: [$frontId],
    accountId: $accountId,
);
$operation = GlobalMap::prepareEventAccountInfo(
    eventId: $eventId,
    frontIds: [$frontId],
    accountId: $accountId,
);
```

### globalmap/eventaccountratings

Read the player ranking for an event and front.

[Official reference](https://developers.wargaming.net/reference/all/wot/globalmap/eventaccountratings/). Realms: asia, eu, na.

Signature (identical on service and static facade):

```php
GlobalMap::eventAccountRatings(
    string $eventId,
    string $frontId,
    array $fields = [],
    int|null $pageNo = null,
    int|null $limit = null,
    int|null $inRating = null,
): ApiResult;
```

| SDK argument / API parameter | Meaning | Required / SDK default | Contract constraints |
| --- | --- | --- | --- |
| `$eventId` / `event_id` | Event ID returned by globalMap()->events(). Provider type: `string`. | Required | No further bound in the reviewed contract. |
| `$frontId` / `front_id` | Front ID(s) returned by globalMap()->fronts(), compatible with the chosen event. Provider type: `string`. | Required | No further bound in the reviewed contract. |
| `$fields` / `fields` | Response field selectors; dot paths include nested fields, a leading minus excludes fields. Provider type: `string, list`. | Optional / `[]` | items/request: 100 |
| `$pageNo` / `page_no` | One-based page number; use iterate/all helpers to traverse pages. Provider type: `numeric`. | Optional / `null` | No further bound in the reviewed contract. |
| `$limit` / `limit` | Maximum number of rows requested per page or response. Provider type: `numeric`. | Optional / `null` | maximum: 100 |
| `$inRating` / `in_rating` | Filter by participation in the ranking. Provider type: `numeric`. | Optional / `null` | values: `1`, `0` |

**Result:** ApiResult. Collection/map of records using WG's original keys; use `$result->record($key)` or `$result->data()`.

Top-level response fields: `account_id` (numeric), `award_level` (string), `battles` (numeric), `battles_to_award` (numeric), `clan_id` (numeric), `clan_rank` (numeric), `event_id` (string), `fame_points` (numeric), `fame_points_to_improve_award` (numeric), `front_id` (string), `rank` (numeric), `rank_delta` (numeric), `updated_at` (timestamp), `url` (string).

Multiget: `prepareEventAccountRatings()` accepts identical arguments and returns PreparedOperation without network I/O. Submit it to `executeMany()`. A paginated preparation represents one page.

Pagination: `iterateEventAccountRatings()` returns Generator of Record/null; `allEventAccountRatings()` returns ApiResult. Both accept the arguments above except pageNo, plus `int $startPage = 1` and `int $maxPages = 1000`. Exhausting the bound throws; all() retains all rows in memory.

<!-- example:globalmap/eventaccountratings -->
```php
// Instance call
$result = $client->globalMap()->eventAccountRatings(
    eventId: $eventId,
    frontId: $frontId,
    limit: 10,
);
$data = $result->data();

// Static alternative; configure the corresponding client first.
$result = GlobalMap::eventAccountRatings(
    eventId: $eventId,
    frontId: $frontId,
    limit: 10,
);
$data = $result->data();

// Prepare for multiget; instance and static alternatives (no I/O).
$operation = $client->globalMap()->prepareEventAccountRatings(
    eventId: $eventId,
    frontId: $frontId,
    limit: 10,
);
$operation = GlobalMap::prepareEventAccountRatings(
    eventId: $eventId,
    frontId: $frontId,
    limit: 10,
);

// Lazy traversal, or collect every page in memory.
$records = $client->globalMap()->iterateEventAccountRatings(
    eventId: $eventId,
    frontId: $frontId,
    limit: 10,
    maxPages: 100,
);
foreach ($records as $key => $record) {
    $row = $record?->data();
}
$all = $client->globalMap()->allEventAccountRatings(
    eventId: $eventId,
    frontId: $frontId,
    limit: 10,
    maxPages: 100,
);

// Static pagination alternatives.
$records = GlobalMap::iterateEventAccountRatings(
    eventId: $eventId,
    frontId: $frontId,
    limit: 10,
    maxPages: 100,
);
foreach ($records as $key => $record) {
    $row = $record?->data();
}
$all = GlobalMap::allEventAccountRatings(
    eventId: $eventId,
    frontId: $frontId,
    limit: 10,
    maxPages: 100,
);
```

### globalmap/eventaccountratingneighbors

Read a player's neighboring ranks in an event ranking.

[Official reference](https://developers.wargaming.net/reference/all/wot/globalmap/eventaccountratingneighbors/). Realms: asia, eu, na.

Signature (identical on service and static facade):

```php
GlobalMap::eventAccountRatingNeighbors(
    string $eventId,
    string $frontId,
    int $accountId,
    array $fields = [],
    int|null $pageNo = null,
    int|null $limit = null,
    int|null $neighboursCount = null,
): ApiResult;
```

| SDK argument / API parameter | Meaning | Required / SDK default | Contract constraints |
| --- | --- | --- | --- |
| `$eventId` / `event_id` | Event ID returned by globalMap()->events(). Provider type: `string`. | Required | No further bound in the reviewed contract. |
| `$frontId` / `front_id` | Front ID(s) returned by globalMap()->fronts(), compatible with the chosen event. Provider type: `string`. | Required | No further bound in the reviewed contract. |
| `$accountId` / `account_id` | Absolute player account ID(s) in the selected realm. Provider type: `numeric`. | Required | No further bound in the reviewed contract. |
| `$fields` / `fields` | Response field selectors; dot paths include nested fields, a leading minus excludes fields. Provider type: `string, list`. | Optional / `[]` | items/request: 100 |
| `$pageNo` / `page_no` | One-based page number; use iterate/all helpers to traverse pages. Provider type: `numeric`. | Optional / `null` | No further bound in the reviewed contract. |
| `$limit` / `limit` | Maximum number of rows requested per page or response. Provider type: `numeric`. | Optional / `null` | maximum: 100 |
| `$neighboursCount` / `neighbours_count` | Number of neighboring ranking entries to request. Provider type: `numeric`. | Optional / `null` | maximum: 99 |

**Result:** ApiResult. Collection/map of records using WG's original keys; use `$result->record($key)` or `$result->data()`.

Top-level response fields: `account_id` (numeric), `award_level` (string), `battles` (numeric), `battles_to_award` (numeric), `clan_id` (numeric), `clan_rank` (numeric), `event_id` (string), `fame_points` (numeric), `fame_points_to_improve_award` (numeric), `front_id` (string), `rank` (numeric), `rank_delta` (numeric), `updated_at` (timestamp), `url` (string).

Multiget: `prepareEventAccountRatingNeighbors()` accepts identical arguments and returns PreparedOperation without network I/O. Submit it to `executeMany()`. A paginated preparation represents one page.

Pagination: `iterateEventAccountRatingNeighbors()` returns Generator of Record/null; `allEventAccountRatingNeighbors()` returns ApiResult. Both accept the arguments above except pageNo, plus `int $startPage = 1` and `int $maxPages = 1000`. Exhausting the bound throws; all() retains all rows in memory.

<!-- example:globalmap/eventaccountratingneighbors -->
```php
// Instance call
$result = $client->globalMap()->eventAccountRatingNeighbors(
    eventId: $eventId,
    frontId: $frontId,
    accountId: $accountId,
    limit: 10,
);
$data = $result->data();

// Static alternative; configure the corresponding client first.
$result = GlobalMap::eventAccountRatingNeighbors(
    eventId: $eventId,
    frontId: $frontId,
    accountId: $accountId,
    limit: 10,
);
$data = $result->data();

// Prepare for multiget; instance and static alternatives (no I/O).
$operation = $client->globalMap()->prepareEventAccountRatingNeighbors(
    eventId: $eventId,
    frontId: $frontId,
    accountId: $accountId,
    limit: 10,
);
$operation = GlobalMap::prepareEventAccountRatingNeighbors(
    eventId: $eventId,
    frontId: $frontId,
    accountId: $accountId,
    limit: 10,
);

// Lazy traversal, or collect every page in memory.
$records = $client->globalMap()->iterateEventAccountRatingNeighbors(
    eventId: $eventId,
    frontId: $frontId,
    accountId: $accountId,
    limit: 10,
    maxPages: 100,
);
foreach ($records as $key => $record) {
    $row = $record?->data();
}
$all = $client->globalMap()->allEventAccountRatingNeighbors(
    eventId: $eventId,
    frontId: $frontId,
    accountId: $accountId,
    limit: 10,
    maxPages: 100,
);

// Static pagination alternatives.
$records = GlobalMap::iterateEventAccountRatingNeighbors(
    eventId: $eventId,
    frontId: $frontId,
    accountId: $accountId,
    limit: 10,
    maxPages: 100,
);
foreach ($records as $key => $record) {
    $row = $record?->data();
}
$all = GlobalMap::allEventAccountRatingNeighbors(
    eventId: $eventId,
    frontId: $frontId,
    accountId: $accountId,
    limit: 10,
    maxPages: 100,
);
```

### globalmap/eventrating

Read the clan ranking for an event and front.

[Official reference](https://developers.wargaming.net/reference/all/wot/globalmap/eventrating/). Realms: asia, eu, na.

Signature (identical on service and static facade):

```php
GlobalMap::eventRating(
    string $eventId,
    string $frontId,
    array $fields = [],
    int|null $pageNo = null,
    int|null $limit = null,
): ApiResult;
```

| SDK argument / API parameter | Meaning | Required / SDK default | Contract constraints |
| --- | --- | --- | --- |
| `$eventId` / `event_id` | Event ID returned by globalMap()->events(). Provider type: `string`. | Required | No further bound in the reviewed contract. |
| `$frontId` / `front_id` | Front ID(s) returned by globalMap()->fronts(), compatible with the chosen event. Provider type: `string`. | Required | No further bound in the reviewed contract. |
| `$fields` / `fields` | Response field selectors; dot paths include nested fields, a leading minus excludes fields. Provider type: `string, list`. | Optional / `[]` | items/request: 100 |
| `$pageNo` / `page_no` | One-based page number; use iterate/all helpers to traverse pages. Provider type: `numeric`. | Optional / `null` | No further bound in the reviewed contract. |
| `$limit` / `limit` | Maximum number of rows requested per page or response. Provider type: `numeric`. | Optional / `null` | maximum: 100 |

**Result:** ApiResult. Collection/map of records using WG's original keys; use `$result->record($key)` or `$result->data()`.

Top-level response fields: `award_level` (string), `battle_fame_points` (numeric), `clan_id` (numeric), `color` (string), `fame_points_to_improve_award` (numeric), `name` (string), `rank` (numeric), `rank_delta` (numeric), `tag` (string), `task_fame_points` (numeric), `total_fame_points` (numeric), `updated_at` (timestamp).

Multiget: `prepareEventRating()` accepts identical arguments and returns PreparedOperation without network I/O. Submit it to `executeMany()`. A paginated preparation represents one page.

Pagination: `iterateEventRating()` returns Generator of Record/null; `allEventRating()` returns ApiResult. Both accept the arguments above except pageNo, plus `int $startPage = 1` and `int $maxPages = 1000`. Exhausting the bound throws; all() retains all rows in memory.

<!-- example:globalmap/eventrating -->
```php
// Instance call
$result = $client->globalMap()->eventRating(
    eventId: $eventId,
    frontId: $frontId,
    limit: 10,
);
$data = $result->data();

// Static alternative; configure the corresponding client first.
$result = GlobalMap::eventRating(
    eventId: $eventId,
    frontId: $frontId,
    limit: 10,
);
$data = $result->data();

// Prepare for multiget; instance and static alternatives (no I/O).
$operation = $client->globalMap()->prepareEventRating(
    eventId: $eventId,
    frontId: $frontId,
    limit: 10,
);
$operation = GlobalMap::prepareEventRating(
    eventId: $eventId,
    frontId: $frontId,
    limit: 10,
);

// Lazy traversal, or collect every page in memory.
$records = $client->globalMap()->iterateEventRating(
    eventId: $eventId,
    frontId: $frontId,
    limit: 10,
    maxPages: 100,
);
foreach ($records as $key => $record) {
    $row = $record?->data();
}
$all = $client->globalMap()->allEventRating(
    eventId: $eventId,
    frontId: $frontId,
    limit: 10,
    maxPages: 100,
);

// Static pagination alternatives.
$records = GlobalMap::iterateEventRating(
    eventId: $eventId,
    frontId: $frontId,
    limit: 10,
    maxPages: 100,
);
foreach ($records as $key => $record) {
    $row = $record?->data();
}
$all = GlobalMap::allEventRating(
    eventId: $eventId,
    frontId: $frontId,
    limit: 10,
    maxPages: 100,
);
```

### globalmap/eventratingneighbors

Read a clan's neighboring ranks in an event ranking.

[Official reference](https://developers.wargaming.net/reference/all/wot/globalmap/eventratingneighbors/). Realms: asia, eu, na.

Signature (identical on service and static facade):

```php
GlobalMap::eventRatingNeighbors(
    string $eventId,
    string $frontId,
    int $clanId,
    array $fields = [],
    int|null $limit = null,
): ApiResult;
```

| SDK argument / API parameter | Meaning | Required / SDK default | Contract constraints |
| --- | --- | --- | --- |
| `$eventId` / `event_id` | Event ID returned by globalMap()->events(). Provider type: `string`. | Required | No further bound in the reviewed contract. |
| `$frontId` / `front_id` | Front ID(s) returned by globalMap()->fronts(), compatible with the chosen event. Provider type: `string`. | Required | No further bound in the reviewed contract. |
| `$clanId` / `clan_id` | Absolute clan ID(s) in the selected realm. Provider type: `numeric`. | Required | No further bound in the reviewed contract. |
| `$fields` / `fields` | Response field selectors; dot paths include nested fields, a leading minus excludes fields. Provider type: `string, list`. | Optional / `[]` | items/request: 100 |
| `$limit` / `limit` | Maximum number of rows requested per page or response. Provider type: `numeric`. | Optional / `null` | maximum: 99 |

**Result:** ApiResult. Collection/map of records using WG's original keys; use `$result->record($key)` or `$result->data()`.

Top-level response fields: `award_level` (string), `battle_fame_points` (numeric), `clan_id` (numeric), `color` (string), `fame_points_to_improve_award` (numeric), `name` (string), `rank` (numeric), `rank_delta` (numeric), `tag` (string), `task_fame_points` (numeric), `total_fame_points` (numeric), `updated_at` (timestamp).

Multiget: `prepareEventRatingNeighbors()` accepts identical arguments and returns PreparedOperation without network I/O. Submit it to `executeMany()`. A paginated preparation represents one page.

<!-- example:globalmap/eventratingneighbors -->
```php
// Instance call
$result = $client->globalMap()->eventRatingNeighbors(
    eventId: $eventId,
    frontId: $frontId,
    clanId: $clanId,
    limit: 10,
);
$data = $result->data();

// Static alternative; configure the corresponding client first.
$result = GlobalMap::eventRatingNeighbors(
    eventId: $eventId,
    frontId: $frontId,
    clanId: $clanId,
    limit: 10,
);
$data = $result->data();

// Prepare for multiget; instance and static alternatives (no I/O).
$operation = $client->globalMap()->prepareEventRatingNeighbors(
    eventId: $eventId,
    frontId: $frontId,
    clanId: $clanId,
    limit: 10,
);
$operation = GlobalMap::prepareEventRatingNeighbors(
    eventId: $eventId,
    frontId: $frontId,
    clanId: $clanId,
    limit: 10,
);
```

### globalmap/info

Read general Global Map settings and availability information.

[Official reference](https://developers.wargaming.net/reference/all/wot/globalmap/info/). Realms: asia, eu, na.

Signature (identical on service and static facade):

```php
GlobalMap::info(
    array $fields = [],
): ApiResult;
```

| SDK argument / API parameter | Meaning | Required / SDK default | Contract constraints |
| --- | --- | --- | --- |
| `$fields` / `fields` | Response field selectors; dot paths include nested fields, a leading minus excludes fields. Provider type: `string, list`. | Optional / `[]` | items/request: 100 |

**Result:** ApiResult. Single object; use `$result->object()` or `$result->data()`.

Top-level response fields: `last_turn` (numeric), `last_turn_calculated_at` (timestamp), `last_turn_created_at` (timestamp), `state` (string).

Multiget: `prepareInfo()` accepts identical arguments and returns PreparedOperation without network I/O. Submit it to `executeMany()`. A paginated preparation represents one page.

<!-- example:globalmap/info -->
```php
// Instance call
$result = $client->globalMap()->info();
$data = $result->data();

// Static alternative; configure the corresponding client first.
$result = GlobalMap::info();
$data = $result->data();

// Prepare for multiget; instance and static alternatives (no I/O).
$operation = $client->globalMap()->prepareInfo();
$operation = GlobalMap::prepareInfo();
```

## stronghold

### stronghold/claninfo

Read Stronghold buildings and statistics for selected clans.

[Official reference](https://developers.wargaming.net/reference/all/wot/stronghold/claninfo/). Realms: asia, eu, na.

Signature (identical on service and static facade):

```php
Stronghold::clanInfo(
    array $clanIds,
    array $fields = [],
    string|null $language = null,
): ApiResult;
```

| SDK argument / API parameter | Meaning | Required / SDK default | Contract constraints |
| --- | --- | --- | --- |
| `$clanIds` / `clan_id` | Absolute clan ID(s) in the selected realm. Provider type: `numeric, list`. | Required | items/request: 10 Required IDs are deduplicated and automatically batched at this limit. |
| `$fields` / `fields` | Response field selectors; dot paths include nested fields, a leading minus excludes fields. Provider type: `string, list`. | Optional / `[]` | items/request: 100 |
| `$language` / `language` | Response language; omission uses the client's configured language. Provider type: `string`. | Optional / `null` | values: `en`, `de`, `pl`, `fr`, `es`, `cs`, `tr` |

**Result:** ApiResult. Collection/map of records using WG's original keys; use `$result->record($key)` or `$result->data()`.

Top-level response fields: `battles_for_strongholds_statistics` (block_header), `battles_series_for_strongholds_statistics` (block_header), `building_slots` (block_header), `clan_id` (numeric), `clan_name` (string), `clan_tag` (string), `command_center_arena_id` (string), `skirmish_statistics` (block_header), `stronghold_buildings_level` (numeric), `stronghold_level` (numeric).

Multiget: `prepareClanInfo()` accepts identical arguments and returns PreparedOperation without network I/O. Submit it to `executeMany()`. A paginated preparation represents one page.

<!-- example:stronghold/claninfo -->
```php
// Instance call
$result = $client->stronghold()->clanInfo(
    clanIds: [$clanId],
);
$data = $result->data();

// Static alternative; configure the corresponding client first.
$result = Stronghold::clanInfo(
    clanIds: [$clanId],
);
$data = $result->data();

// Prepare for multiget; instance and static alternatives (no I/O).
$operation = $client->stronghold()->prepareClanInfo(
    clanIds: [$clanId],
);
$operation = Stronghold::prepareClanInfo(
    clanIds: [$clanId],
);
```

### stronghold/clanreserves

Read reserves available to the authenticated player's clan.

[Official reference](https://developers.wargaming.net/reference/all/wot/stronghold/clanreserves/). Realms: asia, eu, na.

Signature (identical on service and static facade):

```php
Stronghold::clanReserves(
    AccessToken $accessToken,
    array $fields = [],
    string|null $language = null,
): ApiResult;
```

| SDK argument / API parameter | Meaning | Required / SDK default | Contract constraints |
| --- | --- | --- | --- |
| `$accessToken` / `access_token` | Verified, unexpired WgAuth token for the selected realm. Provider type: `string`. | Required | No further bound in the reviewed contract. |
| `$fields` / `fields` | Response field selectors; dot paths include nested fields, a leading minus excludes fields. Provider type: `string, list`. | Optional / `[]` | items/request: 100 |
| `$language` / `language` | Response language; omission uses the client's configured language. Provider type: `string`. | Optional / `null` | values: `en`, `de`, `pl`, `fr`, `es`, `cs`, `tr` |

**Result:** ApiResult. Collection/map of records using WG's original keys; use `$result->record($key)` or `$result->data()`.

Top-level response fields: `bonus_type` (string), `disposable` (boolean), `icon` (string), `in_stock` (block_header), `name` (string), `type` (string).

Multiget: `prepareClanReserves()` accepts identical arguments and returns PreparedOperation without network I/O. Submit it to `executeMany()`. A paginated preparation represents one page.

<!-- example:stronghold/clanreserves -->
```php
// Instance call
$result = $client->stronghold()->clanReserves(
    accessToken: $token,
);
$data = $result->data();

// Static alternative; configure the corresponding client first.
$result = Stronghold::clanReserves(
    accessToken: $token,
);
$data = $result->data();

// Prepare for multiget; instance and static alternatives (no I/O).
$operation = $client->stronghold()->prepareClanReserves(
    accessToken: $token,
);
$operation = Stronghold::prepareClanReserves(
    accessToken: $token,
);
```

### stronghold/activateclanreserve

Activate a reserve of the authenticated player's clan.

[Official reference](https://developers.wargaming.net/reference/all/wot/stronghold/activateclanreserve/). Realms: asia, eu, na.

**Provider write:** this activates a real reserve, requires WG permissions and must only be called after explicit application/user intent. A timeout has an unknown outcome; do not blindly repeat it. The two calls below are alternatives, not a sequence.

Signature (identical on service and static facade):

```php
Stronghold::activateClanReserve(
    AccessToken $accessToken,
    string $reserveType,
    int $reserveLevel,
    array $fields = [],
    string|null $language = null,
): ApiResult;
```

| SDK argument / API parameter | Meaning | Required / SDK default | Contract constraints |
| --- | --- | --- | --- |
| `$accessToken` / `access_token` | Verified, unexpired WgAuth token for the selected realm. Provider type: `string`. | Required | No further bound in the reviewed contract. |
| `$reserveType` / `reserve_type` | Type of an available clan reserve; obtain it from clanReserves(). Provider type: `string`. | Required | No further bound in the reviewed contract. |
| `$reserveLevel` / `reserve_level` | Level of an available clan reserve; obtain it from clanReserves(). Provider type: `numeric`. | Required | No further bound in the reviewed contract. |
| `$fields` / `fields` | Response field selectors; dot paths include nested fields, a leading minus excludes fields. Provider type: `string, list`. | Optional / `[]` | items/request: 100 |
| `$language` / `language` | Response language; omission uses the client's configured language. Provider type: `string`. | Optional / `null` | values: `en`, `de`, `pl`, `fr`, `es`, `cs`, `tr` |

**Result:** ApiResult. Single object; use `$result->object()` or `$result->data()`.

Top-level response fields: `activated_at` (timestamp).

<!-- example:stronghold/activateclanreserve -->
```php
// Instance call
$result = $client->stronghold()->activateClanReserve(
    accessToken: $token,
    reserveType: $reserveType,
    reserveLevel: $reserveLevel,
);
$data = $result->data();

// Static alternative; configure the corresponding client first.
$result = Stronghold::activateClanReserve(
    accessToken: $token,
    reserveType: $reserveType,
    reserveLevel: $reserveLevel,
);
$data = $result->data();
```

## ratings

### ratings/types

Read deprecated player rating types and supported ranking fields.

[Official reference](https://developers.wargaming.net/reference/all/wot/ratings/types/). Realms: asia, eu, na.

**Deprecated:** use the explicit legacy client described above.

Signature (identical on service and static facade):

```php
Ratings::types(
    string|null $language = null,
    array $fields = [],
    string|null $battleType = null,
): ApiResult;
```

| SDK argument / API parameter | Meaning | Required / SDK default | Contract constraints |
| --- | --- | --- | --- |
| `$language` / `language` | Response language; omission uses the client's configured language. Provider type: `string`. | Optional / `null` | values: `en`, `ru`, `pl`, `de`, `fr`, `es`, `zh-cn`, `zh-tw`, `tr`, `cs`, `th`, `vi`, `ko` |
| `$fields` / `fields` | Response field selectors; dot paths include nested fields, a leading minus excludes fields. Provider type: `string, list`. | Optional / `[]` | items/request: 100 |
| `$battleType` / `battle_type` | Battle category filter. Provider type: `string`. | Optional / `null` | values: `company`, `random`, `team`, `default` |

**Result:** ApiResult. Collection/map of records using WG's original keys; use `$result->record($key)` or `$result->data()`.

Top-level response fields: `rank_fields` (list of strings), `threshold` (numeric), `type` (string).

Multiget: `prepareTypes()` accepts identical arguments and returns PreparedOperation without network I/O. Submit it to `executeMany()`. A paginated preparation represents one page.

<!-- example:ratings/types -->
```php
// Instance call
$result = $legacyClient->ratings()->types();
$data = $result->data();

// Static alternative; configure the corresponding client first.
$result = Ratings::types();
$data = $result->data();

// Prepare for multiget; instance and static alternatives (no I/O).
$operation = $legacyClient->ratings()->prepareTypes();
$operation = Ratings::prepareTypes();
```

### ratings/dates

Read available dates for a deprecated player rating type.

[Official reference](https://developers.wargaming.net/reference/all/wot/ratings/dates/). Realms: asia, eu, na.

**Deprecated:** use the explicit legacy client described above.

Signature (identical on service and static facade):

```php
Ratings::dates(
    string $type,
    string|null $language = null,
    array $fields = [],
    string|null $battleType = null,
    array $accountIds = [],
): ApiResult;
```

| SDK argument / API parameter | Meaning | Required / SDK default | Contract constraints |
| --- | --- | --- | --- |
| `$type` / `type` | Search mode, catalog category or rating type, depending on this endpoint. Provider type: `string`. | Required | No further bound in the reviewed contract. |
| `$language` / `language` | Response language; omission uses the client's configured language. Provider type: `string`. | Optional / `null` | values: `en`, `ru`, `pl`, `de`, `fr`, `es`, `zh-cn`, `zh-tw`, `tr`, `cs`, `th`, `vi`, `ko` |
| `$fields` / `fields` | Response field selectors; dot paths include nested fields, a leading minus excludes fields. Provider type: `string, list`. | Optional / `[]` | items/request: 100 |
| `$battleType` / `battle_type` | Battle category filter. Provider type: `string`. | Optional / `null` | values: `company`, `random`, `team`, `default` |
| `$accountIds` / `account_id` | Absolute player account ID(s) in the selected realm. Provider type: `numeric, list`. | Optional / `[]` | items/request: 100 |

**Result:** ApiResult. Single object; use `$result->object()` or `$result->data()`.

Top-level response fields: `dates` (list of timestamps).

Multiget: `prepareDates()` accepts identical arguments and returns PreparedOperation without network I/O. Submit it to `executeMany()`. A paginated preparation represents one page.

<!-- example:ratings/dates -->
```php
// Instance call
$result = $legacyClient->ratings()->dates(
    type: $ratingType,
);
$data = $result->data();

// Static alternative; configure the corresponding client first.
$result = Ratings::dates(
    type: $ratingType,
);
$data = $result->data();

// Prepare for multiget; instance and static alternatives (no I/O).
$operation = $legacyClient->ratings()->prepareDates(
    type: $ratingType,
);
$operation = Ratings::prepareDates(
    type: $ratingType,
);
```

### ratings/accounts

Read selected players' deprecated rating positions.

[Official reference](https://developers.wargaming.net/reference/all/wot/ratings/accounts/). Realms: asia, eu, na.

**Deprecated:** use the explicit legacy client described above.

Signature (identical on service and static facade):

```php
Ratings::accounts(
    string $type,
    array $accountIds,
    string|null $language = null,
    array $fields = [],
    string|null $battleType = null,
    int|string|null $date = null,
): ApiResult;
```

| SDK argument / API parameter | Meaning | Required / SDK default | Contract constraints |
| --- | --- | --- | --- |
| `$type` / `type` | Search mode, catalog category or rating type, depending on this endpoint. Provider type: `string`. | Required | No further bound in the reviewed contract. |
| `$accountIds` / `account_id` | Absolute player account ID(s) in the selected realm. Provider type: `numeric, list`. | Required | items/request: 100 Required IDs are deduplicated and automatically batched at this limit. |
| `$language` / `language` | Response language; omission uses the client's configured language. Provider type: `string`. | Optional / `null` | values: `en`, `ru`, `pl`, `de`, `fr`, `es`, `zh-cn`, `zh-tw`, `tr`, `cs`, `th`, `vi`, `ko` |
| `$fields` / `fields` | Response field selectors; dot paths include nested fields, a leading minus excludes fields. Provider type: `string, list`. | Optional / `[]` | items/request: 100 |
| `$battleType` / `battle_type` | Battle category filter. Provider type: `string`. | Optional / `null` | values: `company`, `random`, `team`, `default` |
| `$date` / `date` | Rating date; use a date returned by the corresponding dates() method. Provider type: `timestamp/date`. | Optional / `null` | No further bound in the reviewed contract. |

**Result:** ApiResult. Collection/map of records using WG's original keys; use `$result->record($key)` or `$result->data()`.

Top-level response fields: `account_id` (numeric), `battles_count` (block_header), `battles_to_play` (numeric), `capture_points` (block_header), `damage_avg` (block_header), `damage_dealt` (block_header), `frags_avg` (block_header), `frags_count` (block_header), `global_rating` (block_header), `hits_ratio` (block_header), `spotted_avg` (block_header), `spotted_count` (block_header), `survived_ratio` (block_header), `wins_ratio` (block_header), `xp_amount` (block_header), `xp_avg` (block_header), `xp_max` (block_header).

Multiget: `prepareAccounts()` accepts identical arguments and returns PreparedOperation without network I/O. Submit it to `executeMany()`. A paginated preparation represents one page.

<!-- example:ratings/accounts -->
```php
// Instance call
$result = $legacyClient->ratings()->accounts(
    type: $ratingType,
    accountIds: [$accountId],
);
$data = $result->data();

// Static alternative; configure the corresponding client first.
$result = Ratings::accounts(
    type: $ratingType,
    accountIds: [$accountId],
);
$data = $result->data();

// Prepare for multiget; instance and static alternatives (no I/O).
$operation = $legacyClient->ratings()->prepareAccounts(
    type: $ratingType,
    accountIds: [$accountId],
);
$operation = Ratings::prepareAccounts(
    type: $ratingType,
    accountIds: [$accountId],
);
```

### ratings/neighbors

Read a player's neighboring positions in a deprecated ranking.

[Official reference](https://developers.wargaming.net/reference/all/wot/ratings/neighbors/). Realms: asia, eu, na.

**Deprecated:** use the explicit legacy client described above.

Signature (identical on service and static facade):

```php
Ratings::neighbors(
    string $type,
    int $accountId,
    string $rankField,
    string|null $language = null,
    array $fields = [],
    string|null $battleType = null,
    int|string|null $date = null,
    int|null $limit = null,
): ApiResult;
```

| SDK argument / API parameter | Meaning | Required / SDK default | Contract constraints |
| --- | --- | --- | --- |
| `$type` / `type` | Search mode, catalog category or rating type, depending on this endpoint. Provider type: `string`. | Required | No further bound in the reviewed contract. |
| `$accountId` / `account_id` | Absolute player account ID(s) in the selected realm. Provider type: `numeric`. | Required | No further bound in the reviewed contract. |
| `$rankField` / `rank_field` | Ranking field obtained from the corresponding types() response. Provider type: `string`. | Required | No further bound in the reviewed contract. |
| `$language` / `language` | Response language; omission uses the client's configured language. Provider type: `string`. | Optional / `null` | values: `en`, `ru`, `pl`, `de`, `fr`, `es`, `zh-cn`, `zh-tw`, `tr`, `cs`, `th`, `vi`, `ko` |
| `$fields` / `fields` | Response field selectors; dot paths include nested fields, a leading minus excludes fields. Provider type: `string, list`. | Optional / `[]` | items/request: 100 |
| `$battleType` / `battle_type` | Battle category filter. Provider type: `string`. | Optional / `null` | values: `company`, `random`, `team`, `default` |
| `$date` / `date` | Rating date; use a date returned by the corresponding dates() method. Provider type: `timestamp/date`. | Optional / `null` | No further bound in the reviewed contract. |
| `$limit` / `limit` | Maximum number of rows requested per page or response. Provider type: `numeric`. | Optional / `null` | maximum: 50 |

**Result:** ApiResult. Collection/map of records using WG's original keys; use `$result->record($key)` or `$result->data()`.

Top-level response fields: `account_id` (numeric), `battles_count` (block_header), `battles_to_play` (numeric), `capture_points` (block_header), `damage_avg` (block_header), `damage_dealt` (block_header), `frags_avg` (block_header), `frags_count` (block_header), `global_rating` (block_header), `hits_ratio` (block_header), `spotted_avg` (block_header), `spotted_count` (block_header), `survived_ratio` (block_header), `wins_ratio` (block_header), `xp_amount` (block_header), `xp_avg` (block_header), `xp_max` (block_header).

Multiget: `prepareNeighbors()` accepts identical arguments and returns PreparedOperation without network I/O. Submit it to `executeMany()`. A paginated preparation represents one page.

<!-- example:ratings/neighbors -->
```php
// Instance call
$result = $legacyClient->ratings()->neighbors(
    type: $ratingType,
    accountId: $accountId,
    rankField: $rankField,
    limit: 10,
);
$data = $result->data();

// Static alternative; configure the corresponding client first.
$result = Ratings::neighbors(
    type: $ratingType,
    accountId: $accountId,
    rankField: $rankField,
    limit: 10,
);
$data = $result->data();

// Prepare for multiget; instance and static alternatives (no I/O).
$operation = $legacyClient->ratings()->prepareNeighbors(
    type: $ratingType,
    accountId: $accountId,
    rankField: $rankField,
    limit: 10,
);
$operation = Ratings::prepareNeighbors(
    type: $ratingType,
    accountId: $accountId,
    rankField: $rankField,
    limit: 10,
);
```

### ratings/top

Read the leading players in a deprecated ranking.

[Official reference](https://developers.wargaming.net/reference/all/wot/ratings/top/). Realms: asia, eu, na.

**Deprecated:** use the explicit legacy client described above.

Signature (identical on service and static facade):

```php
Ratings::top(
    string $type,
    string $rankField,
    string|null $language = null,
    array $fields = [],
    string|null $battleType = null,
    int|string|null $date = null,
    int|null $limit = null,
    int|null $pageNo = null,
): ApiResult;
```

| SDK argument / API parameter | Meaning | Required / SDK default | Contract constraints |
| --- | --- | --- | --- |
| `$type` / `type` | Search mode, catalog category or rating type, depending on this endpoint. Provider type: `string`. | Required | No further bound in the reviewed contract. |
| `$rankField` / `rank_field` | Ranking field obtained from the corresponding types() response. Provider type: `string`. | Required | No further bound in the reviewed contract. |
| `$language` / `language` | Response language; omission uses the client's configured language. Provider type: `string`. | Optional / `null` | values: `en`, `ru`, `pl`, `de`, `fr`, `es`, `zh-cn`, `zh-tw`, `tr`, `cs`, `th`, `vi`, `ko` |
| `$fields` / `fields` | Response field selectors; dot paths include nested fields, a leading minus excludes fields. Provider type: `string, list`. | Optional / `[]` | items/request: 100 |
| `$battleType` / `battle_type` | Battle category filter. Provider type: `string`. | Optional / `null` | values: `company`, `random`, `team`, `default` |
| `$date` / `date` | Rating date; use a date returned by the corresponding dates() method. Provider type: `timestamp/date`. | Optional / `null` | No further bound in the reviewed contract. |
| `$limit` / `limit` | Maximum number of rows requested per page or response. Provider type: `numeric`. | Optional / `null` | maximum: 1000 |
| `$pageNo` / `page_no` | One-based page number; use iterate/all helpers to traverse pages. Provider type: `numeric`. | Optional / `null` | No further bound in the reviewed contract. |

**Result:** ApiResult. Collection/map of records using WG's original keys; use `$result->record($key)` or `$result->data()`.

Top-level response fields: `account_id` (numeric), `battles_count` (block_header), `battles_to_play` (numeric), `capture_points` (block_header), `damage_avg` (block_header), `damage_dealt` (block_header), `frags_avg` (block_header), `frags_count` (block_header), `global_rating` (block_header), `hits_ratio` (block_header), `spotted_avg` (block_header), `spotted_count` (block_header), `survived_ratio` (block_header), `wins_ratio` (block_header), `xp_amount` (block_header), `xp_avg` (block_header), `xp_max` (block_header).

Multiget: `prepareTop()` accepts identical arguments and returns PreparedOperation without network I/O. Submit it to `executeMany()`. A paginated preparation represents one page.

Pagination: `iterateTop()` returns Generator of Record/null; `allTop()` returns ApiResult. Both accept the arguments above except pageNo, plus `int $startPage = 1` and `int $maxPages = 1000`. Exhausting the bound throws; all() retains all rows in memory.

<!-- example:ratings/top -->
```php
// Instance call
$result = $legacyClient->ratings()->top(
    type: $ratingType,
    rankField: $rankField,
    limit: 10,
);
$data = $result->data();

// Static alternative; configure the corresponding client first.
$result = Ratings::top(
    type: $ratingType,
    rankField: $rankField,
    limit: 10,
);
$data = $result->data();

// Prepare for multiget; instance and static alternatives (no I/O).
$operation = $legacyClient->ratings()->prepareTop(
    type: $ratingType,
    rankField: $rankField,
    limit: 10,
);
$operation = Ratings::prepareTop(
    type: $ratingType,
    rankField: $rankField,
    limit: 10,
);

// Lazy traversal, or collect every page in memory.
$records = $legacyClient->ratings()->iterateTop(
    type: $ratingType,
    rankField: $rankField,
    limit: 10,
    maxPages: 100,
);
foreach ($records as $key => $record) {
    $row = $record?->data();
}
$all = $legacyClient->ratings()->allTop(
    type: $ratingType,
    rankField: $rankField,
    limit: 10,
    maxPages: 100,
);

// Static pagination alternatives.
$records = Ratings::iterateTop(
    type: $ratingType,
    rankField: $rankField,
    limit: 10,
    maxPages: 100,
);
foreach ($records as $key => $record) {
    $row = $record?->data();
}
$all = Ratings::allTop(
    type: $ratingType,
    rankField: $rankField,
    limit: 10,
    maxPages: 100,
);
```

## Authentication

WotClient delegates auth to WgAuth AuthClient. These methods return a login URL, an AccessToken or void rather than ApiResult. The token's realm determines prolongation/logout routing. AuthClient also exposes verifyIdentity() and tokenFromData() helpers; browser state and callback orchestration belong to WgAuth, as described in its [README](https://github.com/Edrard/WgAuth#complete-and-verify-the-callback).

### auth/login

Obtain a validated WG login location. Use WgAuth::beginLogin() with its state store for an actual browser login.

[Official reference](https://developers.wargaming.net/reference/all/wot/auth/login/). Realms: eu, na, asia.

```php
Auth::loginLocation(Realm $realm, string $redirectUri, int $tokenLifetime = 3600): string;
```

| SDK argument | API mapping / constraints | Required / default |
| --- | --- | --- |
| `$realm` | Selects the regional API host; not a WG query parameter. | Required |
| `$redirectUri` | Trusted HTTPS callback, sent as redirect_uri. | Required |
| `$tokenLifetime` | 1–1209600 seconds; converted to expires_at. WgAuth sets nofollow=1 and display=page. | Optional / 3600 |

**Result:** string (validated HTTPS WG login URL). Application ID comes from the configured client. These operations use HTTPS POST without automatic retry.

<!-- example:auth/login -->
```php
// Instance call
$location = $client->auth()->loginLocation(
    realm: Realm::EU,
    redirectUri: $callbackUri,
    tokenLifetime: 3600,
);

// Static alternative
$location = Auth::loginLocation(
    realm: Realm::EU,
    redirectUri: $callbackUri,
    tokenLifetime: 3600,
);
```

### auth/prolongate

Extend an existing unexpired token and validate that its account owner remains the same.

[Official reference](https://developers.wargaming.net/reference/all/wot/auth/prolongate/). Realms: eu, na, asia.

```php
Auth::prolongate(AccessToken $token, int $tokenLifetime = 3600): AccessToken;
```

| SDK argument | API mapping / constraints | Required / default |
| --- | --- | --- |
| `$token` | Verified unexpired AccessToken; value is sent as access_token in a POST body. | Required |
| `$tokenLifetime` | 1–1209600 seconds; converted to expires_at. | Optional / 3600 |

**Result:** AccessToken (renewed token, account ID, realm, expiry). Application ID comes from the configured client. These operations use HTTPS POST without automatic retry.

<!-- example:auth/prolongate -->
```php
// Instance call
$renewed = $client->auth()->prolongate(
    token: $token,
    tokenLifetime: 3600,
);

// Static alternative
$renewed = Auth::prolongate(
    token: $token,
    tokenLifetime: 3600,
);
```

### auth/logout

Revoke the supplied WG token. This changes provider session state.

[Official reference](https://developers.wargaming.net/reference/all/wot/auth/logout/). Realms: eu, na, asia.

```php
Auth::logout(AccessToken $token): void;
```

| SDK argument | API mapping / constraints | Required / default |
| --- | --- | --- |
| `$token` | AccessToken to revoke; value is sent as access_token in a POST body. | Required |

**Result:** void (success) or AuthException (failure). Application ID comes from the configured client. These operations use HTTPS POST without automatic retry.

The calls below are alternatives: revoke once, only when your application intends to log the user out.

<!-- example:auth/logout -->
```php
// Instance call
$client->auth()->logout(
    token: $token,
);

// Static alternative
Auth::logout(
    token: $token,
);
```

## Client and result helpers

WotClient's public SDK helpers are independent of the 68 provider endpoints:

Multiget: `$operation = $client->prepare('account/info', ['account_id' => [$accountId]]);` returns PreparedOperation without I/O. `$outcomes = $client->executeMany(['profile' => $operation], concurrency: 10);` returns keyed OperationOutcome objects; `Wot::executeMany()` is the static alternative. Read `result()` only when `succeeded()` is true; otherwise inspect `failure` and successful `parts`. See the [README](../README.md#multiget) for a full example.

| Helper | Example / behavior |
| --- | --- |
| forRealm(Realm) | `$na = $client->forRealm(Realm::NA);` clones realm selection and shares the executor. |
| request(path, parameters = [], token = null) | `$result = $client->request('account/info', ['account_id' => [$accountId]]);` uses API snake_case keys and validates the documented path. |
| pages(path, parameters = [], token = null, startPage = 1, maxPages = 1000) | `$pages = $client->pages('encyclopedia/vehicles', ['limit' => 100]);` yields page number => ApiResult. |
| iterate(path, parameters = [], token = null, startPage = 1, maxPages = 1000) | `$rows = $client->iterate('encyclopedia/vehicles', ['limit' => 100]);` yields key => Record/null. |
| all(path, parameters = [], token = null, startPage = 1, maxPages = 1000) | `$all = $client->all('encyclopedia/vehicles', ['limit' => 100]);` returns merged ApiResult. |
| Group accessors / auth() | `$service = $client->accounts();` or `$auth = $client->auth();`; all nine accessors are listed in the README. |
| Wot::configure / client / reset | `Wot::configure($client); $same = Wot::client(); Wot::reset();` manages explicit static configuration. |
| Wot::forRealm / group accessors / auth | `$na = Wot::forRealm(Realm::NA); $service = Wot::accounts(); $auth = Wot::auth();` delegates to the configured client. |
| AuthClient::verifyIdentity(AccessToken) | `$identity = $client->auth()->verifyIdentity($token);` verifies token ownership using private account data and returns Identity; no separate Auth static facade method. |
| AuthClient::tokenFromData(Realm, array) | `$candidate = $client->auth()->tokenFromData(Realm::EU, $tokenResponse);` validates token response shape and expiry and returns AccessToken; it does not verify ownership or browser state. Use WgAuth's completeLogin() for browser callbacks. |
| ApiResult data / meta / count / has / get | `$data = $result->data(); $meta = $result->meta; $count = $result->count(); $exists = $result->has($key); $value = $result->get($key);` preserves absent/null distinctions. |
| ApiResult record / records / object | `$row = $result->record($key); $rows = $result->records(); $object = $result->object();` supplies Record containers matching the response shape. |
| Record get / has / string / integer / boolean / data | `$present = $row->has('nickname'); $name = $row->string('nickname'); $id = $row->integer('account_id'); $premium = $row->boolean('is_premium'); $statistics = $row->get('statistics'); $data = $row->data();` reads top-level fields; traverse nested arrays explicitly. |

Refer to the README for error types, transport injection, quotas, private data handling and pagination failure semantics. Tests execute every method example against mock transports; no live authentication, revocation or reserve activation is performed.
