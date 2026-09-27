# WotClient — World of Tanks API for PHP 8.5

Explicit typed methods for WoT EU, NA and ASIA, response validation, ID batching and lazy pagination. Each API group has its own service class and optional static facade. MIT; authored for Edrard.

WotClient composes [WgApi](https://github.com/Edrard/WgApi) 2.x (URL building), [WgDataGetter](https://github.com/Edrard/WgDataGetter) 2.2+ (GET transport, WG envelopes and single-attempt multiget) and [WgAuth](https://github.com/Edrard/WgAuth) 1.0.2+ (authentication with credential-safe transport defaults). These are MIT dependencies; Guzzle 7 (MIT) provides the POST transport. WgParser processes collected statistics separately and is not required by this client. No Laravel dependency, database, scheduler or automatic server-wide scan is introduced.

## API version and documentation

**API version/namespace: `wot`; endpoint prefix: `/wot/`. Reviewed contract date: 2026-09-27. SDK release: 1.2.0.**

WG's [request format guide](https://developers.wargaming.net/documentation/guide/getting-started/#request-format) defines the API_name URL segment as the API version; the reviewed World of Tanks methods use `wot`. The reviewed contracts do not expose a separate numeric API version. This identifier is separate from the game version returned by encyclopedia/info and this library's semantic version.

Regional API bases: `https://api.worldoftanks.eu/wot/`, `https://api.worldoftanks.com/wot/`, `https://api.worldoftanks.asia/wot/`.

The [complete method reference](docs/METHODS.md) documents **all 68 available catalog methods**, with purpose, full PHP signature, every argument and constraint, return shape, official reference, and an instance and static example for each. It also documents every generated pagination helper and the general client/result helpers. Available catalog methods include deprecated or permission-dependent methods; catalog coverage does not guarantee provider availability.

## Installation

Composer package: `edrard/wotclient`; stable constraint: `^1.2.0`. Requires PHP `^8.5` and the extensions required by the WG dependencies (including curl, ctype, filter and session).

Until registration on Packagist, declare **all four repositories in the consuming application's root composer.json**. Composer does not inherit repositories from dependencies:

```json
{
    "repositories": [
        { "type": "vcs", "url": "https://github.com/Edrard/WotClient.git" },
        { "type": "vcs", "url": "https://github.com/Edrard/WgApi.git" },
        { "type": "vcs", "url": "https://github.com/Edrard/WgDataGetter.git" },
        { "type": "vcs", "url": "https://github.com/Edrard/WgAuth.git" }
    ],
    "require": { "php": "^8.5", "edrard/wotclient": "^1.2.0" }
}
```

Run `composer install`, or `composer update` when adding the package to an existing project. Local development can replace the WotClient VCS entry with a path repository and `options.versions.edrard/wotclient = 1.2.0`; production builds should resolve versioned sources.

## Instance client

```php
require __DIR__.'/vendor/autoload.php';

use edrard\WgApi\Realm;
use edrard\WotClient\WotClient;

$id = getenv('WG_APPLICATION_ID') ?: throw new LogicException('Configure WG_APPLICATION_ID.');
$client = new WotClient($id, realm: Realm::EU); // one ID explicitly applies to all three realms
// Alternatively: new WotClient(['eu' => $euId, 'na' => $naId, 'asia' => $asiaId]);

$accounts = $client->accounts()->info(
    accountIds: [500000001, 500000002],
    fields: ['account_id', 'nickname', 'statistics.all.battles'],
);
$account = $accounts->record(500000001); // null for an unavailable account
$nickname = $account?->string('nickname');

$players = $client->accounts()->search('Player', limit: 10);
$clans = $client->clans()->search(search: 'WOT', limit: 10);
$asia = $client->forRealm(Realm::ASIA); // leaves the original client configured for EU
```

`accountIds` and other numeric lists take positive PHP integers, not numeric strings. Required account/clan/vehicle ID lists are deduplicated and split at each method's documented limit (for example account/info: 100, stronghold/claninfo: 10). Results retain absolute provider IDs; no region offset is added. Optional filter lists are validated against their limits and are not automatically split, because splitting arbitrary combinations can duplicate or change query results.

## Static methods

```php
use edrard\WotClient\Facades\Accounts;
use edrard\WotClient\Facades\Encyclopedia;
use edrard\WotClient\Facades\Wot;

Wot::configure($client);
try {
    $accounts = Accounts::info([500000001], fields: ['nickname']);
    $vehicles = Encyclopedia::vehicles(limit: 10, fields: ['tank_id', 'name']);
    // Alternative static entry point, with the same instance service:
    $accounts = Wot::accounts()->info([500000001], fields: ['nickname']);
    $naAccounts = Wot::forRealm(Realm::NA)->accounts()->info([1000000001]);
} finally {
    Wot::reset();
}
```

All group facades delegate to the configured client with the same explicit signatures and named arguments. There is no magic `__callStatic`, hidden environment lookup or second implementation. Configure before use; otherwise a LogicException is raised. Facade configuration is process-local mutable state: prefer instance injection for applications, concurrent work and multi-tenant workers; reset between independent jobs. Independent clients may use different IDs, realms, languages and executors.

## Multiget

Use the client configured above and account IDs for the same realm:

```php
$accountIds = [500000001, 500000002];
$operations = [
    'profiles' => $client->accounts()->prepareInfo($accountIds),
    'vehicles' => $client->accounts()->prepareTanks($accountIds),
    'achievements' => $client->accounts()->prepareAchievements($accountIds),
];
$outcomes = $client->executeMany($operations, concurrency: 10);
foreach ($outcomes as $name => $outcome) {
    if ($outcome->succeeded()) {
        $data = $outcome->result()->data();
        continue;
    }
    $failure = $outcome->failure; // kind, providerCode, retryable, attempts, retryAfter
    foreach ($outcome->parts as $part) {
        if ($part->succeeded()) {
            $completedChunk = $part->result()->data();
        }
    }
}
```

Every read method has a `prepare…()` counterpart with identical typed arguments, including static group facades. Preparation validates without network I/O. `Wot::executeMany($operations, concurrency: 10)` uses the configured client. Operations retain their realm and may mix EU, NA and ASIA. See the [complete method reference](docs/METHODS.md) for each preparation example. A prepared paginated method fetches one page; existing pagination helpers remain available.

The client splits required ID lists at each endpoint's provider limit, then submits all HTTP chunks to one shared WgDataGetter queue. Concurrency (1–10) bounds actual HTTP requests across operations and chunks. Multiget executes each wire request once, including 429/504; the caller owns retries, request resizing and cooldown. Legacy synchronous GET calls retain their configured transport RetryPolicy. Outcomes preserve caller keys/order. Failed operations retain successful chunks in `parts`; `result()` never returns incomplete data as a successful complete result. Invalid preparation fails before I/O. Infrastructure exceptions may still propagate.

Synchronous RequestExecutorInterface implementations remain supported. Custom multiget executors implement BatchRequestExecutorInterface; injected getters implement SingleAttemptDataGetterInterface. Provider writes and authentication retain their existing explicit methods.

Private multiget reads accept a verified WgAuth AccessToken and use authenticated HTTPS GET through WgDataGetter. Tokens can therefore appear in transport URLs: do not log raw parameters, URLs or private responses. Library debug output and failures redact credentials. Synchronous token requests still use POST. Responses have no package-defined size cap.

## API groups and coverage

| Instance accessor | Service / static facade | Purpose |
| --- | --- | --- |
| accounts() | Accounts | Search, personal data, vehicles, achievements, WTR |
| tanks() | Tanks | Vehicle statistics, achievements and mastery distribution |
| encyclopedia() | Encyclopedia | Vehicles, configurations, modules, maps, missions, crew and catalogs |
| clans() | Clans | Search, details, members, glossary, message board and history |
| clanRatings() | ClanRatings | Rating types, dates, clans, neighbors and top clans |
| globalMap() | GlobalMap | Fronts, provinces, clans, seasons, events and ratings |
| stronghold() | Stronghold | Clan data, reserves and explicit reserve activation |
| ratings() | Ratings | Deprecated historical player ratings; opt-in only |
| auth() | WgAuth AuthClient / Facades Auth | Login URL, token extension and revocation |

The [complete endpoint table](docs/ENDPOINTS.md) maps the official 2026-09-27 catalog: 65 explicit data/operation methods plus the three auth methods delegated to WgAuth. Twelve catalog methods are marked deprecated by WG and disabled by default. Historical callers can explicitly use `allowDeprecated: true`; this does not guarantee provider availability. Other games and undocumented historical APIs are outside the package.

## Pagination

Every service method with a documented page_no parameter also provides `iterateX()` and `allX()` methods:

```php
foreach ($client->encyclopedia()->iterateVehicles(
    fields: ['tank_id', 'name'],
    limit: 100,
    startPage: 1,
    maxPages: 100,
) as $tankId => $vehicle) {
    $name = $vehicle?->string('name');
    // Process each record; only the current page is retained by the iterator.
}

$allVehicles = $client->encyclopedia()->allVehicles(fields: ['tank_id', 'name']);
$onePage = $client->encyclopedia()->vehicles(pageNo: 2, limit: 100);

// Low-level page iteration for a documented endpoint:
foreach ($client->pages('globalmap/provinces', ['front_id' => $frontId, 'limit' => 100]) as $pageNo => $page) {
    // $page is an ApiResult, including the page's WG metadata.
}
```

Pagination uses meta.page_total when provided; otherwise it continues until an empty page. A short page alone does not prove completion. Incorrect metadata, consecutive repeated pages and exhausted maxPages raise exceptions instead of returning silently truncated results. Start pages are explicit. List rows receive consecutive iterator keys across pages; ID-indexed maps retain keys. `allX()` accumulates data in memory and rejects duplicate map keys across pages. Dynamic provider data may change during iteration; this is not a transactional snapshot. Early consumer termination makes no further requests.

## Results and validation

ApiResult provides `data()`, `meta`, `count()`, `has($key)`, `get($key)`, `record($key)`, `records()` and `object()`. Use `object()` for single-object responses such as encyclopedia/info; `get($accountId)` for list-valued entries such as account/tanks. Record supports `get()`, `has()`, `string()`, `integer()`, `boolean()` and explicit `data()` access.

Validation covers known parameter types, required values, enums, list limits, documented numeric bounds, field selector syntax, search length, WG envelope shape and the documented response fields that are present, including nested rows. Unknown response fields are retained for forward compatibility. Selected-out fields are not required, null is preserved, and absent fields remain distinguishable through has(). Known IDs are checked against the requested batch. This validates structure, not the truth or freshness of WG statistics. Results are typed containers with explicit accessors; this release does not provide a separate entity DTO with properties for every provider field.

Single-request results retain WG metadata. Automatically merged ID batches expose a count and each batch's original metadata under `meta.batches`; all-page results expose count and pages. A failed batch returns no partial ApiResult. Earlier rows already consumed from a lazy iterator cannot be rolled back.

## Tokens and authentication

```php
use edrard\WgAuth\WgAuth;

// Use WgAuth's browser-bound atomic StateStoreInterface to complete actual login.
$flow = new WgAuth($client->auth(), $stateStore);
$location = $flow->beginLogin(Realm::EU, $trustedHttpsCallback);

// $account = $flow->completeLogin($callbackQuery);
// AccessToken is a value object returned by verified login, never an arbitrary query parameter.
$private = $client->accounts()->info(
    [$account->identity->accountId],
    fields: ['account_id', 'private.is_premium'],
    accessToken: $account->token,
);

$renewed = $client->auth()->prolongate($account->token);
$client->auth()->logout($renewed);
```

Token-bearing operations use HTTPS POST bodies, never URL query parameters. Tokens must match the client realm and be unexpired; unsupported tokens and garage filters without a token fail before transport. Use WgAuth's [browser login and callback guidance](https://github.com/Edrard/WgAuth#complete-and-verify-the-callback). The callback's raw query must be redacted in web-server/proxy/APM logs. WotClient does not establish application sessions or store tokens. Private result data remains private; do not log data(), serialize results to public responses or expose credentials. Default debug output redacts result/record data and executor credentials.

Stronghold::activateClanReserve() is an explicit provider write requiring an AccessToken and appropriate WG permissions. Neither it nor other POST operations are retried automatically. A timeout can leave an unknown outcome. Real reserve activation is never performed by the included tests or examples.

## Dependency injection, errors and quotas

RequestExecutorInterface is the transport boundary for test doubles and custom implementations. DefaultRequestExecutor can take a dedicated WgDataGetter/DataGetterInterface, Guzzle ClientInterface for POST and RateLimiterInterface. Default GET and POST share one local 10 requests/second limiter; for an injected getter configure that getter with the same limiter yourself. forRealm() shares the executor/limiter while keeping realm selection independent. WgAuth's own transport is separate and does not join that limiter. Multiple clients/processes and authentication need application-wide quota coordination.

Invalid arguments raise InvalidArgumentException. Provider, transport and pagination failures raise ClientException; invalid responses raise InvalidResponseException. Numeric providerCode/httpStatus are safe diagnostics. Default exceptions omit credentials, URLs, raw bodies and provider messages; credential-bearing transport exceptions are never chained. GET uses WgDataGetter's bounded retry policy; POST has no automatic retry. Timeouts are 15 seconds overall and 5 seconds to connect, TLS verification is enabled, redirects disabled. Custom executors must preserve these credential and mutation guarantees.

The stable release reads complete POST response bodies without a package-defined byte limit. Injected Guzzle query defaults are cleared and transport debug is disabled. The directly used guzzlehttp/psr7 dependency (MIT) provides the stream-reading utilities. Custom transports/middleware must preserve credential protections.

## Development and examples

```sh
composer install
composer test
composer analyse
composer format:check
composer validate --strict
composer audit --locked

# Regenerate signatures offline, then normalize PSR-12:
python3 tools/generate-endpoints.py
composer format

# Construction only; requires WG_APPLICATION_ID:
php examples/basic.php
# Explicit single public read:
php examples/basic.php --run
# Read-only matrix including full vehicle pagination, ID from env or stdin:
php examples/verify-regions.php
```

The reviewed resources/endpoints.json snapshot contains factual paths, parameter constraints and response field types from the official WG documentation, without credentials, player data or copied explanatory text. Runtime use performs no documentation fetch. Generated services/facades have explicit PHP signatures for IDEs and static analysis; core validation/execution/pagination is hand-written and tested independently.

Tests use fixtures and mock transports, including routing all 65 data methods through both instance and static APIs. Live verification covers the methods printed by verify-regions.php; it does not prove every catalog endpoint is available. Real user callback, private access, renewal/revocation and reserve activation are not claimed as live-verified. Intended consumers: explicitly integrated PHP applications and the future Laravel website; no website integration or deployment has been performed.

Official sources: [WoT reference](https://developers.wargaming.net/reference/all/wot/account/list/), [application identification and quotas](https://developers.wargaming.net/documentation/guide/principles/). Source repository: [Edrard/WotClient](https://github.com/Edrard/WotClient); license: [MIT](LICENSE).

Dependency updates: run `composer update "edrard/*" --with-all-dependencies --prefer-stable` in the consuming application to upgrade the WG complex to the latest versions allowed by its constraints. Caret constraints allow compatible upgrades; `composer install` preserves the lock file. Dependency repositories must be declared in the application root.

Parameter validation marks its parameter array SensitiveParameter, including rejected raw access_token input, so validation exception traces redact it when zend.exception_ignore_args=0.

## Caller-sized batches (N values, K per request)

```php
$operations = $client->prepareBatch('account/info', range(1, 250), batchSize: 25);
$outcomes = $client->executeMany($operations, concurrency: 10); // ten requests of 25 IDs
foreach ($outcomes as $index => $outcome) {
    if ($outcome->succeeded()) {
        $data = $outcome->result()->data();
    } else {
        foreach ($outcome->failures() as $failure) {
            // Safe kind/providerCode/attempts/retryAfter; decide recovery in the application.
        }
        foreach ($outcome->parts as $part) {
            $requested = $part->request->parameters(); // Application data; do not log private parameters.
        }
    }
}

$names = $client->prepareBatch('account/list', ['PlayerOne', 'PlayerTwo', 'PlayerThree'], 2);
$nameOutcomes = $client->executeMany($names); // exact searches: two names, then one

Wot::configure($client);
$prepared = Wot::prepareBatch('account/info', [1, 2, 3], 2);
$staticOutcomes = Wot::executeMany($prepared);
Wot::reset();
```

prepareBatch(path, values, batchSize, parameters=[], accessToken=null) accepts a list of IDs or exact account names and returns PreparedOperation objects without I/O. K must fit the selected endpoint's documented limit; an invalid K is rejected before execution, rather than silently replaced. Empty values produce no operations. Other endpoint arguments go in parameters. Exact account names must be supplied individually without commas; type=exact is selected automatically. Parameter names, values, realm and tokens use the same endpoint validation as ordinary methods.

executeMany returns one keyed outcome per prepared operation. Each wire part retains its request identity and every failure is available through failures(); the compatibility summary failure combines retryability and the largest Retry-After. This is diagnostic metadata, not a client recovery policy. WgBatch repacks missing values and repeats operations. Existing methods still support mechanical splitting at provider maxima when no explicit K is supplied.

## Mix API methods in one multiget

For one account, all three requests share one concurrency pool:

```php
$outcomes = $client->executeMany([
    'info' => $client->accounts()->prepareInfo([123]),
    'tanks' => $client->accounts()->prepareTanks([123]),
    'achievements' => $client->accounts()->prepareAchievements([123]),
], concurrency: 10);

if ($outcomes['info']->succeeded()) {
    $information = $outcomes['info']->result()->data();
}
// Inspect tanks and achievements independently; one failure does not discard siblings.
```

For a group, specify K and combine prepared requests from different methods:

```php
$ids = range(1, 250);
$operations = [];
foreach (['account/info', 'account/tanks', 'account/achievements'] as $method) {
    foreach ($client->prepareBatch($method, $ids, batchSize: 25) as $index => $operation) {
        $operations[$method.':'.$index] = $operation;
    }
}
$outcomes = $client->executeMany($operations, concurrency: 10);
foreach ($outcomes as $key => $outcome) {
    if ($outcome->succeeded()) {
        $data = $outcome->result()->data();
    } else {
        $failures = $outcome->failures();
        // Pass this outcome to the application's recovery policy; do not log private parameters.
    }
}
```

This prepares 30 requests (10 for each method), with at most 10 actual HTTP requests outstanding across all methods. Caller keys and outcomes are preserved. Preparation sends nothing; executeMany executes each request once. WgBatch owns subsequent recovery and adaptive K, separately for each dataset's missing IDs.
