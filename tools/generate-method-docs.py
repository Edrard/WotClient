"""Generate the full method reference using globals from generate-endpoints.py.

Descriptions below are original summaries of the reviewed API contracts. Examples
use application-owned variables, never real credentials or recorded player data.
"""

PURPOSES = {
    "account/list": "Search player accounts by nickname.",
    "account/info": "Read account profiles, aggregate statistics and authorized private fields.",
    "account/tanks": "Read the vehicles associated with each account and their summary statistics.",
    "account/achievements": "Read account achievement counters.",
    "account/wtr": "Read account World of Tanks Rating statistics.",
    "tanks/stats": "Read an account's detailed statistics for selected vehicles.",
    "tanks/achievements": "Read an account's achievement counters for selected vehicles.",
    "tanks/mastery": "Read vehicle mastery thresholds for the requested distribution and percentiles.",
    "stronghold/claninfo": "Read Stronghold buildings and statistics for selected clans.",
    "stronghold/clanreserves": "Read reserves available to the authenticated player's clan.",
    "stronghold/activateclanreserve": "Activate a reserve of the authenticated player's clan.",
    "globalmap/fronts": "List Global Map fronts and their configuration.",
    "globalmap/provinces": "List provinces of one Global Map front using optional filters.",
    "globalmap/claninfo": "Read Global Map information and statistics for selected clans.",
    "globalmap/clanprovinces": "Read provinces held by each selected clan.",
    "globalmap/clanbattles": "Read scheduled Global Map battles for a clan.",
    "globalmap/seasons": "List Global Map seasons.",
    "globalmap/seasonclaninfo": "Read a clan's season results for selected vehicle levels.",
    "globalmap/seasonaccountinfo": "Read a player's season results for selected vehicle levels.",
    "globalmap/seasonrating": "Read the clan ranking for a season and vehicle level.",
    "globalmap/seasonratingneighbors": "Read a clan's neighboring ranks in a season ranking.",
    "globalmap/events": "List Global Map events.",
    "globalmap/eventclaninfo": "Read a clan's event results for selected fronts.",
    "globalmap/eventaccountinfo": "Read a player's event results for selected fronts.",
    "globalmap/eventaccountratings": "Read the player ranking for an event and front.",
    "globalmap/eventaccountratingneighbors": "Read a player's neighboring ranks in an event ranking.",
    "globalmap/eventrating": "Read the clan ranking for an event and front.",
    "globalmap/eventratingneighbors": "Read a clan's neighboring ranks in an event ranking.",
    "globalmap/info": "Read general Global Map settings and availability information.",
    "encyclopedia/tanks": "Read the deprecated vehicle catalog; prefer vehicles().",
    "encyclopedia/tankinfo": "Read deprecated vehicle details; prefer vehicles() or vehicleProfile().",
    "encyclopedia/vehicles": "Read the vehicle catalog, including characteristics and default configurations.",
    "encyclopedia/vehicleprofile": "Read one vehicle's characteristics for a chosen module configuration.",
    "encyclopedia/tankengines": "Read the deprecated engine catalog; prefer modules().",
    "encyclopedia/tankturrets": "Read the deprecated turret catalog; prefer modules().",
    "encyclopedia/tankradios": "Read the deprecated radio catalog; prefer modules().",
    "encyclopedia/tankchassis": "Read the deprecated suspension catalog; prefer modules().",
    "encyclopedia/tankguns": "Read the deprecated gun catalog; prefer modules().",
    "encyclopedia/achievements": "Read achievement definitions and display metadata.",
    "encyclopedia/info": "Read encyclopedia metadata, game version and supported vehicle categories.",
    "encyclopedia/arenas": "Read battle arena definitions.",
    "encyclopedia/provisions": "Read equipment and consumable definitions.",
    "encyclopedia/personalmissions": "Read personal mission campaigns, operations and tasks.",
    "encyclopedia/boosters": "Read personal reserve definitions.",
    "encyclopedia/vehicleprofiles": "Read the available configuration profiles for one vehicle.",
    "encyclopedia/modules": "Read vehicle module definitions.",
    "encyclopedia/badges": "Read badge definitions and display metadata.",
    "encyclopedia/crewroles": "Read crew role definitions.",
    "encyclopedia/crewskills": "Read crew skill and perk definitions.",
    "ratings/types": "Read deprecated player rating types and supported ranking fields.",
    "ratings/dates": "Read available dates for a deprecated player rating type.",
    "ratings/accounts": "Read selected players' deprecated rating positions.",
    "ratings/neighbors": "Read a player's neighboring positions in a deprecated ranking.",
    "ratings/top": "Read the leading players in a deprecated ranking.",
    "clanratings/types": "Read clan rating definitions and supported ranking fields.",
    "clanratings/dates": "Read available clan rating dates.",
    "clanratings/clans": "Read selected clans' rating positions.",
    "clanratings/neighbors": "Read a clan's neighboring positions in a clan ranking.",
    "clanratings/top": "Read the leading clans for one ranking field.",
    "clans/list": "Search clans by name or tag, or list clans with optional filters.",
    "clans/info": "Read clan profiles and membership information.",
    "clans/accountinfo": "Read clan membership information for selected accounts.",
    "clans/glossary": "Read clan-related terminology and role labels.",
    "clans/messageboard": "Read the authenticated player's clan message board.",
    "clans/memberhistory": "Read an account's clan membership history.",
}

MEANINGS = {
    "access_token": "Verified, unexpired WgAuth token for the selected realm.",
    "account_id": "Absolute player account ID(s) in the selected realm.",
    "clan_id": "Absolute clan ID(s) in the selected realm.",
    "tank_id": "Vehicle ID(s) from encyclopedia/vehicles.",
    "arena_id": "Arena ID filter from encyclopedia/arenas.",
    "battle_type": "Battle category filter.",
    "campaign_id": "Personal mission campaign ID filter.",
    "daily_revenue_gte": "Minimum province daily revenue.",
    "daily_revenue_lte": "Maximum province daily revenue.",
    "date": "Rating date; use a date returned by the corresponding dates() method.",
    "distribution": "Distribution used to calculate mastery thresholds.",
    "engine_id": "Engine module ID for the selected vehicle.",
    "event_id": "Event ID returned by globalMap()->events().",
    "extra": "Additional response fields; only the listed selectors are supported.",
    "fields": "Response field selectors; dot paths include nested fields, a leading minus excludes fields.",
    "front_id": "Front ID(s) returned by globalMap()->fronts(), compatible with the chosen event.",
    "gun_id": "Gun module ID for the selected vehicle.",
    "in_garage": "Garage filter; requires a matching accessToken.",
    "in_rating": "Filter by participation in the ranking.",
    "landing_type": "Province landing category filter.",
    "language": "Response language; omission uses the client's configured language.",
    "limit": "Maximum number of rows requested per page or response.",
    "members_key": "How clan member rows are indexed in the response.",
    "module_id": "Module ID filter from encyclopedia/modules.",
    "nation": "Vehicle/module nation filter.",
    "neighbours_count": "Number of neighboring ranking entries to request.",
    "operation_id": "Personal mission operation ID filter.",
    "order_by": "Provider sort order.",
    "page_no": "One-based page number; use iterate/all helpers to traverse pages.",
    "percentile": "Percentile positions for the mastery distribution.",
    "prime_hour": "Province prime-time hour filter.",
    "profile_id": "Configuration profile ID for the selected vehicle.",
    "province_id": "Province ID filter from globalMap()->provinces().",
    "provision_id": "Equipment/consumable ID filter from encyclopedia/provisions.",
    "radio_id": "Radio module ID for the selected vehicle.",
    "rank_field": "Ranking field obtained from the corresponding types() response.",
    "reserve_level": "Level of an available clan reserve; obtain it from clanReserves().",
    "reserve_type": "Type of an available clan reserve; obtain it from clanReserves().",
    "role": "Crew role filter.",
    "search": "Nickname, clan name or clan tag search text, depending on the method.",
    "season_id": "Season ID returned by globalMap()->seasons().",
    "set_id": "Equipment/consumable set filter.",
    "skill": "Crew skill filter.",
    "status": "Provider status filter.",
    "suspension_id": "Suspension module ID for the selected vehicle.",
    "tag": "Clan tag filter.",
    "tier": "Vehicle or module tier filter.",
    "turret_id": "Turret module ID for the selected vehicle.",
    "type": "Search mode, catalog category or rating type, depending on this endpoint.",
    "vehicle_level": "Vehicle level(s) used by the selected Global Map season.",
}


def constraints(schema):
    rules = []
    for key, label in [("min", "minimum"), ("max", "maximum"), ("maxItems", "items/request"),
                       ("minLength", "minimum length"), ("maxLength", "maximum length")]:
        if schema.get(key) is not None:
            rules.append(f"{label}: {schema[key]}")
    if schema.get("choices"):
        rules.append("values: " + ", ".join(f"`{v}`" for v in schema["choices"]))
    return "; ".join(rules) or "No further bound in the reviewed contract."


def example_value(name, schema):
    samples = {"account_id": "$accountId", "clan_id": "$clanId", "tank_id": "$tankId",
               "access_token": "$token", "season_id": "$seasonId", "event_id": "$eventId",
               "front_id": "$frontId", "rank_field": "$rankField", "reserve_type": "$reserveType",
               "reserve_level": "$reserveLevel", "type": "$ratingType", "search": "'Player'",
               "distribution": "'xp'", "percentile": "[50, 90]", "vehicle_level": "'10'"}
    value = samples[name]
    if ", list" in schema["type"] and not value.startswith("["):
        value = "[" + value + "]"
    return value


def call(target, method, arguments, assignment="$result"):
    if not arguments:
        return f"{assignment} = {target}{method}();"
    return f"{assignment} = {target}{method}(\n" + "\n".join(
        f"    {name}: {value}," for name, value in arguments) + "\n);"


assert set(PURPOSES) == set(snapshot["endpoints"]), "Every endpoint needs an original purpose summary."
lines = ["# Complete WoT method reference", "",
         "API version/namespace: **`wot`**, URL prefix **`/wot/`**. Contract reviewed **" + snapshot["checkedAt"] + "**. SDK documentation: **1.0.1**.", "",
         "All 68 catalog methods are covered: 65 data/operation methods and three WgAuth methods. Each entry includes all SDK arguments, the mapped API parameters, return shape, instance and static examples. Pagination helpers are included where supported.", "",
         "## Example setup and conventions", "",
         "Run the setup once in your application. Code blocks below are independent alternatives: choose the instance or static call. Do not run every block as a script.", "",
         "```php", "require __DIR__.'/vendor/autoload.php';", "",
         "use edrard\\WgApi\\Realm;", "use edrard\\WotClient\\WotClient;",
         "use edrard\\WotClient\\Facades\\{Accounts, Tanks, Encyclopedia, Clans, ClanRatings, GlobalMap, Stronghold, Ratings, Auth, Wot};", "",
         "$applicationId = getenv('WG_APPLICATION_ID') ?: throw new LogicException('Configure WG_APPLICATION_ID.');",
         "$client = new WotClient($applicationId, realm: Realm::EU);", "Wot::configure($client);", "```", "",
         "Supply `$accountId`, `$clanId` and `$tankId` as positive integers obtained from the corresponding search/catalog in the same realm. `$frontId`, `$eventId`, `$seasonId` and `$rankField` come from fronts/events/seasons/types responses; do not assume a particular season or ranking is currently available. `$ratingType` comes from ratings/types (deprecated). `$token` is the AccessToken from a verified WgAuth login, not a raw callback string. `$reserveType` and positive integer `$reserveLevel` come from clanReserves(). `$callbackUri` is your trusted HTTPS callback URL.", "",
         "`application_id` is configured on WotClient, not passed into each method. Optional `null`/empty-array arguments are omitted from the provider request; WG chooses omitted defaults except language, which defaults to the client language. Numeric lists contain integers. String lists contain strings. See the per-method official link for provider field descriptions and evolving defaults.", "",
         "All data methods return ApiResult. `data()` preserves provider keys, lists, nulls and selected fields; `meta` retains metadata. `record($key)` reads a collection row, `get($key)` reads a nested list, `object()` reads a single object. Fields listed below are available top-level selectors, not guaranteed required keys: selecting fields may omit others. Nested selectors and their field types are in the [reviewed schema](../resources/endpoints.json) and each official reference.", "",
         "For deprecated examples, explicitly create `$legacyClient = new WotClient($applicationId, realm: Realm::EU, allowDeprecated: true);`. Configure `Wot::configure($legacyClient)` before their static alternatives; restore `Wot::configure($client)` afterwards. Provider availability is not guaranteed. Call `Wot::reset()` at the end of an independent job.", "",
         "## Index", ""]
for section, (group, accessor) in GROUPS.items():
    lines.append(f"- [{group}](#{accessor.lower()})")
lines += ["- [Authentication](#authentication)", ""]

for section, (group, accessor) in GROUPS.items():
    lines += [f"## {accessor}", ""]
    for path, endpoint in snapshot["endpoints"].items():
        if not path.startswith(section + "/"):
            continue
        method = METHODS.get(path.split("/")[1], path.split("/")[1])
        lines += [f"### {path}", "", PURPOSES[path], "",
                  f"[Official reference](https://developers.wargaming.net/reference/all/wot/{path}/). Realms: " + ", ".join(endpoint["realms"]) + ".", ""]
        if endpoint["deprecated"]:
            lines += ["**Deprecated:** use the explicit legacy client described above.", ""]
        if endpoint["write"]:
            lines += ["**Provider write:** this activates a real reserve, requires WG permissions and must only be called after explicit application/user intent. A timeout has an unknown outcome; do not blindly repeat it. The two calls below are alternatives, not a sequence.", ""]
        parameters = [(n, s) for n, s in endpoint["parameters"].items() if n != "application_id"]
        parameters.sort(key=lambda pair: not pair[1]["required"])
        signatures = [parameter(n, s)[2].replace("#[SensitiveParameter] ", "") for n, s in parameters]
        lines += ["Signature (identical on service and static facade):", "", "```php",
                  f"{group}::{method}(\n" + "\n".join("    " + p + "," for p in signatures) + "\n): ApiResult;", "```", "",
                  "| SDK argument / API parameter | Meaning | Required / SDK default | Contract constraints |",
                  "| --- | --- | --- | --- |"]
        for name, schema in parameters:
            _, camel, signature, _ = parameter(name, schema)
            required = "Required" if schema["required"] else ("Optional / `[]`" if ", list" in schema["type"] else "Optional / `null`")
            rules = constraints(schema)
            if name == endpoint["batchParameter"]:
                rules += " Required IDs are deduplicated and automatically batched at this limit."
            lines.append(f"| `${camel}` / `{name}` | {MEANINGS[name]} Provider type: `{schema['type']}`. | {required} | {rules} |")
        shape = {"object": "Single object; use `$result->object()` or `$result->data()`.",
                 "collection": "Collection/map of records using WG's original keys; use `$result->record($key)` or `$result->data()`.",
                 "nestedList": "Map containing nested lists (often keyed by account/clan ID); use `$result->get($key)` or `$result->data()`."}[endpoint["layout"]]
        roots = sorted((name, kind) for name, kind in endpoint["fields"].items() if "." not in name)
        lines += ["", "**Result:** ApiResult. " + shape, "",
                  "Top-level response fields: " + (", ".join(f"`{n}` ({t})" for n, t in roots) or "See the official response schema.") + ".", ""]
        arguments = [(parameter(n, s)[1], example_value(n, s)) for n, s in parameters if s["required"]]
        if path == "clans/list":
            arguments.append(("search", "'WOT'"))
        if "limit" in endpoint["parameters"]:
            arguments.append(("limit", str(max(10, endpoint["parameters"]["limit"].get("min") or 1))))
        instance = "$legacyClient" if endpoint["deprecated"] else "$client"
        snippet = "// Instance call\n" + call(f"{instance}->{accessor}()->", method, arguments) + "\n$data = $result->data();\n\n// Static alternative; configure the corresponding client first.\n" + call(f"{group}::", method, arguments) + "\n$data = $result->data();"
        if not endpoint["write"]:
            prepared = "prepare" + method[0].upper() + method[1:]
            lines += [f"Multiget: `{prepared}()` accepts identical arguments and returns PreparedOperation without network I/O. Submit it to `executeMany()`. A paginated preparation represents one page.", ""]
            snippet += "\n\n// Prepare for multiget; instance and static alternatives (no I/O).\n" + call(f"{instance}->{accessor}()->", prepared, arguments, "$operation") + "\n" + call(f"{group}::", prepared, arguments, "$operation")
        if "page_no" in endpoint["parameters"]:
            suffix = method[0].upper() + method[1:]
            paged_arguments = arguments + [("maxPages", "100")]
            snippet += "\n\n// Lazy traversal, or collect every page in memory.\n" + call(f"{instance}->{accessor}()->", "iterate" + suffix, paged_arguments, "$records") + "\nforeach ($records as $key => $record) {\n    $row = $record?->data();\n}\n" + call(f"{instance}->{accessor}()->", "all" + suffix, paged_arguments, "$all")
            snippet += "\n\n// Static pagination alternatives.\n" + call(f"{group}::", "iterate" + suffix, paged_arguments, "$records") + "\nforeach ($records as $key => $record) {\n    $row = $record?->data();\n}\n" + call(f"{group}::", "all" + suffix, paged_arguments, "$all")
            lines += [f"Pagination: `iterate{suffix}()` returns Generator of Record/null; `all{suffix}()` returns ApiResult. Both accept the arguments above except pageNo, plus `int $startPage = 1` and `int $maxPages = 1000`. Exhausting the bound throws; all() retains all rows in memory.", ""]
        lines += [f"<!-- example:{path} -->", "```php", snippet, "```", ""]

lines += ["## Authentication", "",
          "WotClient delegates auth to WgAuth AuthClient. These methods return a login URL, an AccessToken or void rather than ApiResult. The token's realm determines prolongation/logout routing. AuthClient also exposes verifyIdentity() and tokenFromData() helpers; browser state and callback orchestration belong to WgAuth, as described in its [README](https://github.com/Edrard/WgAuth#complete-and-verify-the-callback).", ""]
AUTH = {
    "login": ("loginLocation", "Obtain a validated WG login location. Use WgAuth::beginLogin() with its state store for an actual browser login.",
              "Realm $realm, string $redirectUri, int $tokenLifetime = 3600", "string (validated HTTPS WG login URL)",
              [("realm", "Realm::EU"), ("redirectUri", "$callbackUri"), ("tokenLifetime", "3600")], "$location",
              [("realm", "Selects the regional API host; not a WG query parameter.", "Required"),
               ("redirectUri", "Trusted HTTPS callback, sent as redirect_uri.", "Required"),
               ("tokenLifetime", "1–1209600 seconds; converted to expires_at. WgAuth sets nofollow=1 and display=page.", "Optional / 3600")]),
    "prolongate": ("prolongate", "Extend an existing unexpired token and validate that its account owner remains the same.",
                   "AccessToken $token, int $tokenLifetime = 3600", "AccessToken (renewed token, account ID, realm, expiry)",
                   [("token", "$token"), ("tokenLifetime", "3600")], "$renewed",
                   [("token", "Verified unexpired AccessToken; value is sent as access_token in a POST body.", "Required"),
                    ("tokenLifetime", "1–1209600 seconds; converted to expires_at.", "Optional / 3600")]),
    "logout": ("logout", "Revoke the supplied WG token. This changes provider session state.",
               "AccessToken $token", "void (success) or AuthException (failure)",
               [("token", "$token")], None,
               [("token", "AccessToken to revoke; value is sent as access_token in a POST body.", "Required")]),
}
for slug, (method, purpose, signature, result, arguments, assignment, parameters) in AUTH.items():
    path = "auth/" + slug
    lines += [f"### {path}", "", purpose, "",
              f"[Official reference](https://developers.wargaming.net/reference/all/wot/{path}/). Realms: eu, na, asia.", "",
              "```php", f"Auth::{method}({signature}): " + ("string" if slug == "login" else "AccessToken" if slug == "prolongate" else "void") + ";", "```", "",
              "| SDK argument | API mapping / constraints | Required / default |", "| --- | --- | --- |"]
    lines += [f"| `${n}` | {meaning} | {required} |" for n, meaning, required in parameters]
    lines += ["", "**Result:** " + result + ". Application ID comes from the configured client. These operations use HTTPS POST without automatic retry.", ""]
    if slug == "logout":
        lines += ["The calls below are alternatives: revoke once, only when your application intends to log the user out.", ""]
    snippet = "// Instance call\n" + call("$client->auth()->", method, arguments, assignment or "$unused")
    snippet += "\n\n// Static alternative\n" + call("Auth::", method, arguments, assignment or "$unused")
    if assignment is None:
        snippet = snippet.replace("$unused = ", "")
    lines += [f"<!-- example:{path} -->", "```php", snippet, "```", ""]

lines += ["## Client and result helpers", "",
          "WotClient's public SDK helpers are independent of the 68 provider endpoints:", "",
          "Multiget: `$operation = $client->prepare('account/info', ['account_id' => [$accountId]]);` returns PreparedOperation without I/O. `$outcomes = $client->executeMany(['profile' => $operation], concurrency: 10);` returns keyed OperationOutcome objects; `Wot::executeMany()` is the static alternative. Read `result()` only when `succeeded()` is true; otherwise inspect `failure` and successful `parts`. See the [README](../README.md#multiget) for a full example.", "",
          "| Helper | Example / behavior |", "| --- | --- |",
          "| forRealm(Realm) | `$na = $client->forRealm(Realm::NA);` clones realm selection and shares the executor. |",
          "| request(path, parameters = [], token = null) | `$result = $client->request('account/info', ['account_id' => [$accountId]]);` uses API snake_case keys and validates the documented path. |",
          "| pages(path, parameters = [], token = null, startPage = 1, maxPages = 1000) | `$pages = $client->pages('encyclopedia/vehicles', ['limit' => 100]);` yields page number => ApiResult. |",
          "| iterate(path, parameters = [], token = null, startPage = 1, maxPages = 1000) | `$rows = $client->iterate('encyclopedia/vehicles', ['limit' => 100]);` yields key => Record/null. |",
          "| all(path, parameters = [], token = null, startPage = 1, maxPages = 1000) | `$all = $client->all('encyclopedia/vehicles', ['limit' => 100]);` returns merged ApiResult. |",
          "| Group accessors / auth() | `$service = $client->accounts();` or `$auth = $client->auth();`; all nine accessors are listed in the README. |",
          "| Wot::configure / client / reset | `Wot::configure($client); $same = Wot::client(); Wot::reset();` manages explicit static configuration. |",
          "| Wot::forRealm / group accessors / auth | `$na = Wot::forRealm(Realm::NA); $service = Wot::accounts(); $auth = Wot::auth();` delegates to the configured client. |",
          "| AuthClient::verifyIdentity(AccessToken) | `$identity = $client->auth()->verifyIdentity($token);` verifies token ownership using private account data and returns Identity; no separate Auth static facade method. |",
          "| AuthClient::tokenFromData(Realm, array) | `$candidate = $client->auth()->tokenFromData(Realm::EU, $tokenResponse);` validates token response shape and expiry and returns AccessToken; it does not verify ownership or browser state. Use WgAuth's completeLogin() for browser callbacks. |",
          "| ApiResult data / meta / count / has / get | `$data = $result->data(); $meta = $result->meta; $count = $result->count(); $exists = $result->has($key); $value = $result->get($key);` preserves absent/null distinctions. |",
          "| ApiResult record / records / object | `$row = $result->record($key); $rows = $result->records(); $object = $result->object();` supplies Record containers matching the response shape. |",
          "| Record get / has / string / integer / boolean / data | `$present = $row->has('nickname'); $name = $row->string('nickname'); $id = $row->integer('account_id'); $premium = $row->boolean('is_premium'); $statistics = $row->get('statistics'); $data = $row->data();` reads top-level fields; traverse nested arrays explicitly. |", "",
          "Refer to the README for error types, transport injection, quotas, private data handling and pagination failure semantics. Tests execute every method example against mock transports; no live authentication, revocation or reserve activation is performed.", ""]
(ROOT / "docs/METHODS.md").write_text("\n".join(lines), encoding="utf-8")
print("Generated reference and instance/static examples for all 68 methods.")
