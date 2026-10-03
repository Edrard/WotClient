# WotClient

PHP 8.5 World of Tanks GET client with typed methods grouped into `accounts()`, `tanks()`, `encyclopedia()`, `clans()`, `clanRatings()`, `globalMap()`, `stronghold()`, and `ratings()`. Methods validate outgoing parameters, ask WgApi to build URLs, send them together through WgDataGetter, and return the getter's **raw per-URL results without interpreting WG responses**. Static facades delegate to the same instance client.

**API namespace/version: `wot` (`/wot/` URLs); endpoint catalog snapshot: 2026-09-27. Next SDK release: 3.0.0, currently an unreleased worktree.** The catalog does not provide a separate numeric WG API version. See [every available GET method, signature and example](docs/METHODS.md) and the [endpoint table](docs/ENDPOINTS.md).

The 12 GET methods marked **Deprecated** in the bundled WG catalog remain callable with the standard client. Their entries in both references and their PHPDoc carry the label. It is informational: the client sends the request and returns its raw HTTP result; current provider availability is determined by WG's response.

WotClient depends on WgApi 3.x for URL construction and WgDataGetter 3.x for GET transport. WgAuth is independent: login, token renewal and logout are performed directly with WgAuth. POST operations are outside this GET client.

## N and K

The caller supplies N IDs and K IDs per URL. WotClient divides the N inputs into groups of at most K; it neither chooses K nor imposes a request-frequency or concurrency quota. WgApi builds one URL per group. Getter sends all generated URLs in one multirequest and retries only the transient failures. A call with 250 IDs and K=25 therefore creates ten URLs and returns ten `FetchResult` objects, in group order.

```php
use edrard\WotClient\WotClient;

$client = new WotClient($applicationId);
$ids = range(500000001, 500000250);
$results = $client->accounts()->info(
    accountIds: $ids,
    batchSize: 25,
    fields: ['account_id', 'nickname'],
    extra: ['statistics.random'],
    language: 'de',
);

foreach ($results as $chunk => $result) {
    // $result->body contains the complete WG response body for this URL.
    // $result->httpStatus, ->transportFailure and ->attempts describe HTTP execution.
    // Decode or interpret WG JSON in the application above this client.
}
```

The same N/K mechanism handles exact nickname searches:

```php
$results = $client->accounts()->searchExactMany(
    names: ['Alpha', 'Bravo', 'Charlie'],
    batchSize: 2,
);
// Two URLs, submitted to Getter together: Alpha,Bravo and Charlie.
```

For `account/list`, an array of names represents an **exact** nickname batch. Generic `request()` and `prepare()` accept `type: 'exact'`, or an omitted/null type that defaults to `exact` for this array form. Any other explicit type raises `InvalidArgumentException` before HTTP execution; the client never replaces an explicit `startswith` with `exact`.

For prefix searches, pass one string per operation and send the prepared operations together:

```php
$results = $client->accounts()->search(search: 'Edr', type: 'startswith');
// One URL with search=Edr and type=startswith.

$results = $client->executeMany([
    'edr' => $client->accounts()->prepareSearch(search: 'Edr', type: 'startswith'),
    'jov' => $client->accounts()->prepareSearch(search: 'Jov', type: 'startswith'),
]);
// Two URLs in one multirequest; both keep type=startswith.
// Raw results are available as $results['edr'][0] and $results['jov'][0].
```

This conflicting generic call is rejected:

```php
try {
    $client->request('account/list', [
        'search' => ['Edr', 'Jov'],
        'type' => 'startswith',
    ], batchSize: 2);
} catch (\InvalidArgumentException $exception) {
    // No HTTP request was sent. Use separate prepareSearch() operations above.
}
```

For a method without an ID list, one call builds one URL and still returns a one-element list of `FetchResult`. Page numbers are ordinary request parameters; the client does not automatically walk pages or interpret `meta`.

## Default and per-request language

The constructor's `language` is the default for methods that accept it; it is `en` when omitted. An explicit request language takes precedence for that request and leaves the default unchanged. Use `setLanguage()` to change the default for future calls and preparations on the same client:

```php
$client = new WotClient($applicationId, language: 'de');
$results = $client->encyclopedia()->info();                // de
$results = $client->encyclopedia()->info(language: 'fr');  // fr for this call
$results = $client->encyclopedia()->info();                // still de

$prepared = $client->encyclopedia()->prepareInfo();        // captures de
$client->setLanguage('en');
$results = $client->encyclopedia()->info();                // now en
$results = $client->executeMany(['info' => $prepared]);     // prepared request stays de
```

A prepared operation retains its effective language even when another client executes it. Passing `language: null` uses the current default when preparing the operation. Methods without a language parameter receive none. `forRealm()` returns a clone with the current default; changing either object's default later affects only that object. Static calls use the configured instance and can change its default with `Wot::setLanguage('fr')`.

## Mixed methods in one multirequest

Preparation validates input without network I/O. `executeMany()` builds URLs for all prepared operations, invokes Getter once, then groups **unchanged** results by your operation keys. Operations can use different WoT methods and realms.

```php
use edrard\WgApi\Realm;

$operations = [
    'profiles' => $client->accounts()->prepareInfo($ids, batchSize: 25),
    'vehicles' => $client->accounts()->prepareTanks($ids, batchSize: 25),
    'achievements' => $client->accounts()->prepareAchievements($ids, batchSize: 25),
];
$results = $client->executeMany($operations);
// $results['profiles'][0] is the first profile FetchResult.

$asia = $client->forRealm(Realm::ASIA);
$results = $client->executeMany([
    'eu' => $client->accounts()->prepareInfo([500000001], batchSize: 1),
    'asia' => $asia->accounts()->prepareInfo([2000000001], batchSize: 1),
]);
```

No successful bodies are merged. HTTP failures stay with their URL; WG `status: error`, `status: ok`, null `data`, and even invalid JSON are passed through exactly as Getter received them. WotClient does not decide whether to retry a completed Getter result or whether IDs are missing.

## Static calls and authentication

```php
use edrard\WotClient\Facades\Accounts;
use edrard\WotClient\Facades\Wot;

Wot::configure($client);
try {
    $results = Accounts::info([500000001], batchSize: 1);
} finally {
    Wot::reset();
}
```

Facade configuration is process-local mutable state; use instance injection for long-running or concurrent applications. Private GET methods accept an `accessToken` string and pass it to the URL builder over HTTPS. WgAuth supplies and manages such tokens independently. Do not log token-bearing URLs or raw private responses. WotClient does not perform POST or own sessions.

The caller controls N, K, call frequency and provider quotas. Supplying K larger than a WG method permits will produce a provider error; WotClient does not silently resize it. For an externally configured Getter, set its timeout and retry policy there; defaults are 40 seconds to connect, 120 seconds overall, and three attempts for transient failures.

Inject a dedicated Getter instance for this client. Its URL queue is consumed by each call. For a bounded public live smoke test, configure `WG_APPLICATION_ID` in your environment and run `php examples/smoke-eu.php` or `php examples/verify-regions.php`; the latter sends EU, NA and ASIA URLs in one multirequest and prints only statuses. These examples use one attempt and shorter timeouts so a connectivity failure is quick to diagnose.

MIT license. Package: `edrard/wotclient`. After 3.0.0 and its dependency tags are published, consumers should use `^3.0`. Source: [Edrard/WotClient](https://github.com/Edrard/WotClient). Development checks: `composer test`, `composer analyse`, `composer format:check`, `composer validate --strict` on PHP 8.5. Regenerate typed service methods and per-method examples with `node tools/generate-client.mjs`.

This library does not commit `composer.lock`, so development installs resolve the newest compatible dependency releases. Before the unpublished 3.0.0 dependency tags exist, repository tests load the adjacent WgApi and WgDataGetter source trees through `tests/bootstrap.php`.

CI checks out all three repositories as siblings and resolves the dependency branches through temporary root path-repository settings. These development checks do not require published 3.0.0 tags.

## Public client contract

Load Composer's `vendor/autoload.php` in a consuming application with compatible 3.x dependencies. All classes below use namespace `edrard\WotClient`, unless stated otherwise. Documentation describes this working tree; installing a published 2.x version does not provide this contract.

| Method | Return / behavior |
| --- | --- |
| `__construct(string|array $applicationIds, Realm $realm = Realm::EU, string $language = 'en', ?UrlBuilderInterface $urls = null, ?DataGetterInterface $getter = null)` | A string ID configures all three realms; an array configures only its named realms. Supports URL-builder and Getter injection. |
| `forRealm(Realm $realm): WotClient` | Clone using the requested realm. URL builder and Getter are shared with the original; language defaults are independent. |
| `setLanguage(string $language): void` | Changes the default; validation against a method's catalog occurs when preparing or executing that method. |
| `accounts()`, `tanks()`, `encyclopedia()`, `clans()`, `clanRatings()`, `globalMap()`, `stronghold()`, `ratings()` | Return the corresponding typed service; all method signatures and examples are in [METHODS.md](docs/METHODS.md). |
| `request(string $path, array $parameters = [], ?int $batchSize = null): array` | Generic GET entry point; returns `list<FetchResult>`. Use catalog paths such as `account/info`, without `wot/`. |
| `prepare(string $path, array $parameters = [], ?int $batchSize = null): PreparedOperation` | Validates and captures effective language without HTTP I/O. |
| `executeMany(array $operations): array` | Accepts keyed `PreparedOperation` objects; returns `array<int|string, list<FetchResult>>` with the same operation keys. Empty input returns `[]`. |

`UrlBuilderInterface` is `edrard\WgApi\UrlBuilderInterface`; `DataGetterInterface` is `edrard\WgGetter\Contracts\DataGetterInterface`; `Realm` is `edrard\WgApi\Realm`. The client exposes no separate request-executor interface. These two dependency interfaces are its injection points.

```php
use edrard\WgApi\GetWgApi;
use edrard\WgGetter\RetryPolicy;
use edrard\WgGetter\WgDataGetter;

$client = new WotClient(
    applicationIds: $applicationId,
    urls: new GetWgApi(['eu' => $applicationId]),
    getter: new WgDataGetter(
        timeout: 180,
        connectTimeout: 60,
        retry: new RetryPolicy(maxAttempts: 3, baseDelay: 5, maxDelay: 30),
    ),
);
$results = $client->request('account/info', [
    'account_id' => [1, 2],
    'fields' => ['nickname'],
    'extra' => ['statistics.random'],
    'language' => 'de',
], batchSize: 1);
// Two URLs, two raw results; this generic form uses API parameter names.
```

Typed methods use camelCase names such as `accountIds`, `accessToken` and `batchSize`; generic `request()` and `prepare()` use WG query names such as `account_id` and `access_token`. Each typed method accepts all non-`application_id` parameters in the bundled catalog for that endpoint. `fields`, `extra`, `language`, filters and pagination arguments are available where that endpoint defines them, rather than universally on every method. Null and empty optional lists are omitted. Unknown generic parameters and caller-supplied `application_id` are rejected.

Outgoing validation checks required parameters, integer types and ranges, string lengths, catalog choices and field-selector syntax. Required ID lists must be non-empty; K must be positive for batched methods and absent for methods without batching. Validation errors and unsupported paths/realms raise `InvalidArgumentException` before HTTP execution. A missing realm application ID raises `LogicException`. HTTP and network failures are returned in `FetchResult`; unexpected dependency exceptions propagate. An injected Getter that omits a requested result causes `LogicException`.

`PreparedOperation::__construct(Realm $realm, string $path, array $parameters, ?int $batchSize = null)` is also public. Its readonly public properties are `realm`, `path` and `batchSize`; `parameters(): array` returns the supplied parameters. Direct construction does not validate or capture a default language: `executeMany()` validates it and supplies the executing client's default if needed. The language-retention examples above concern operations created through client/service preparation. Debug output redacts parameters.

`Facades\Wot` exposes static `configure(WotClient): void`, `reset(): void`, `client(): WotClient`, `forRealm(Realm): WotClient`, `setLanguage(string): void`, `executeMany(array): array` and all eight service accessors. An unconfigured facade throws `LogicException`. Each group facade exposes both the ordinary and `prepareX()` methods with the same arguments as its service; `Wot::forRealm()` returns an instance and does not change the global facade configuration.

## Raw output

An illustrative `accounts()->info([1, 2], batchSize: 1)` result contains two `edrard\WgGetter\FetchResult` objects:

```text
[0] httpStatus=200, body='{"status":"ok","data":{"1":null}}',
    transportFailure=false, attempts=1, retryAfter=null
[1] httpStatus=200, body='{"status":"error","error":{"code":407,"message":"INVALID_IP_ADDRESS"}}',
    transportFailure=false, attempts=1, retryAfter=null
```

Both have `succeeded() === true` because HTTP succeeded; the application interprets WG status. An exhausted timeout instead has `httpStatus=null`, `body=null`, `transportFailure=true` and normally `attempts=3`. Getter preserves complete response text, including whitespace, error envelopes and invalid JSON. For mixed operations the same objects appear under your operation keys, for example `$results['profiles'][0]`; the client does not extract account records from the body.

The per-method reference contains 64 GET endpoint examples plus the exact-nickname batch helper, in both instance and static forms. Sample IDs and names illustrate argument shape and are not claims that these records exist. Before using static examples, import the matching `Facades` class and configure `Wot`. Optional private-data examples require a real user token obtained outside this client.

## Installation

After all three 3.0.0 releases are published: `composer require edrard/wotclient:^3.0`. The dependency ranges resolve compatible WgApi and Getter versions. This command cannot install the unpublished local changes from released 2.x packages.

For local development, put path repositories in the **consuming application's root** `composer.json`. Adjust these relative paths to that application's directory:

```json
{
  "repositories": [
    {"type": "path", "url": "../WgApi", "options": {"versions": {"edrard/wgapi": "3.0.x-dev"}}},
    {"type": "path", "url": "../WgDataGetter", "options": {"versions": {"edrard/wggetter": "3.0.x-dev"}}},
    {"type": "path", "url": "../WotClient", "options": {"versions": {"edrard/wotclient": "3.0.x-dev"}}}
  ],
  "require": {
    "php": "^8.5",
    "edrard/wgapi": "^3.0@dev",
    "edrard/wggetter": "^3.0@dev",
    "edrard/wotclient": "^3.0@dev"
  },
  "prefer-stable": true
}
```

Then run `composer update` in that consuming application. This is an example for a new development consumer; merge the relevant entries into an existing project's configuration rather than replacing it. The combined runtime requirements include `ext-curl`, `ext-ctype` and `ext-filter` from the dependencies. Repository-level tests use adjacent source trees; application code should load properly resolved Composer dependencies.

Maintained examples: `examples/basic.php` configures a static facade and sends a request only with `--run`; `examples/smoke-eu.php` and `examples/verify-regions.php` perform live public checks immediately. All require `WG_APPLICATION_ID`. The smoke scripts load adjacent checkout sources via the test bootstrap; `basic.php` loads normal Composer dependencies. Each documentation code block assumes the imports and application variables shown in the preceding examples, unless it includes its own setup.
