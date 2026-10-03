# Changelog

## Unreleased 3.0.0 — 2026-10-01

- Reject conflicting explicit search types for nickname arrays instead of silently replacing them with exact; document exact batching and mixed prefix searches.
- Capture default or per-request language in prepared operations; add instance and static setLanguage() for future calls without changing existing preparations.
- Allow deprecated GET methods without opt-in; remove allowDeprecated and mark legacy methods in generated references and PHPDoc.
- Make caller-supplied N/K the sole ID and exact-nickname grouping mechanism; form one URL per group through WgApi and execute all URLs through Getter together.
- Return Getter FetchResult objects unchanged, grouped by caller operation key for mixed methods; remove WG JSON validation, result merging, pagination interpretation, client retries and quotas.
- Keep typed GET service methods and static facades. Move auth and POST fully outside the client. This major version has not yet been tagged as a release.
- Reuse the real Getter queue in test doubles; verify atomic append, duplicate rejection and queue consumption. Run CI against sibling 3.x source checkouts until dependency releases exist.

## 1.2.1 - 2026-09-28

- Keep caller-sized batch documentation in the generated method reference and update the generator SDK version.
- Fix the generated-signature CI check; runtime behavior is unchanged from 1.2.0.

## 1.2.0 - 2026-09-28

- Add prepareBatch(path, values, batchSize, parameters, accessToken), including the static facade, for caller-sized N/K read requests and exact account names.
- Execute multiget once per wire request through WgDataGetter ^2.2; collection retries and cooldown belong to the caller.
- Preserve every part failure and its PreparedOperation identity; aggregate all retryability/Retry-After metadata without dropping later failures.
- Retain existing endpoint-limit preparation, synchronous methods and successful partial data.

## 1.1.3 - 2026-09-28

- Protect parameter arrays in validation stack traces, including rejected raw access tokens.
- Require WgAuth ^1.0.2 and test request/preparation failures with exception arguments enabled.
- Refresh all dependencies to the latest compatible stable versions.

## 1.1.2 — 2026-09-28

- Require WgAuth ^1.0.1 so installations include cleared inherited POST query defaults, disabled debug output and complete authentication response reads without the former byte cap.
- Refresh the dependency lock and document the stable dependency minimum; existing client methods are unchanged.

## 1.1.1 — 2026-09-27

- Update README SDK/install versions and local development override to the multiget release; place the multiget example after client setup and include example account IDs. No runtime changes.

## 1.1.0 — 2026-09-27

- Add immutable PreparedOperation, prepare methods for all 64 read endpoints on instance/static services, and keyed executeMany outcomes.
- Flatten endpoint-limit chunks across operations/realms into the WgDataGetter 2.1 multiget queue; leave HTTP concurrency and retries in the getter.
- Validate each response and ID mapping independently; retain successful parts of partially failed operations without exposing an incomplete overall result as success.
- Add BatchRequestExecutorInterface without changing synchronous executor contracts; preserve explicit auth/write methods and existing pagination.
- Document every preparation method with examples; verify actual Guzzle concurrency, complete merging, partial failures, realm routing and early write rejection.

- Remove the previous 8 MiB POST response cap and read complete bodies, including short stream reads, without a package-defined size limit.
- Clear injected Guzzle query defaults and disable inherited debug output to keep credentials out of URLs and transport logs.
- Validate both page/page_no metadata and reject scalar lists where a record object is expected.
- Declare the directly used PSR-7 dependency and add security regressions; retain explicit POST operations without retries.

## 1.0.1 — 2026-09-27

- Document the official `wot` API version/namespace and contract review date separately from game and SDK versions.
- Add the complete reference for all 68 catalog methods: every argument, constraint, signature, return shape, official link and instance/static example; include pagination and client/result helpers.
- Generate documentation offline and verify every method example with mock transports in the test suite and CI. No runtime behavior changes.

## 1.0.0 — 2026-09-27

- Initial PHP 8.5 World of Tanks SDK for EU, NA and ASIA, composing stable WgApi 2.x, WgDataGetter 2.x and WgAuth 1.x.
- Eight separate services with explicit typed signatures for all 65 non-auth methods in the reviewed official catalog; three authentication methods delegate to WgAuth.
- Optional static group facades with explicit configuration/reset, matching instance signatures and dependency injection through RequestExecutorInterface.
- Parameter and present-field response validation, partial/null-safe ApiResult and Record containers, automatic required-ID batching at endpoint-specific limits.
- Lazy page/record iteration and all-page collection with metadata checks, repeated-page detection and a safety limit that fails explicitly on incomplete results.
- Token-bearing HTTPS POST requests, no automatic POST retries, fixed provider origins, disabled redirects and credential-safe errors/debug output.
- Deprecated endpoints require explicit opt-in. Stronghold reserve activation is an explicit write; no live mutation tests are included.
- English README, examples, endpoint coverage table, offline reviewed contract snapshot/generator and PHP 8.5 CI.

Validation: local fixture/mock tests, PHPStan level 6, PSR-12 and Composer checks. Read-only live checks cover 17 scenarios in each of EU/NA/ASIA, including full vehicle pagination. Full catalog availability and real private/authentication/write operations are not claimed as live-verified.
