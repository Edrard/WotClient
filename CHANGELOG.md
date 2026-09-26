# Changelog

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
