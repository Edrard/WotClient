"""Generate explicit service/facade signatures from the reviewed, offline contract snapshot.

Run with Python 3 from any directory. No network or API data is accessed.
The generator owns Services/{group}.php, Facades/{group}.php and docs/ENDPOINTS.md.
Core classes, tests and Facades/Wot.php and Facades/Auth.php remain hand-written.
"""
import json
from pathlib import Path

ROOT = Path(__file__).resolve().parents[1]
snapshot = json.loads((ROOT / "resources/endpoints.json").read_text())
GROUPS = {"account": ("Accounts", "accounts"), "tanks": ("Tanks", "tanks"),
          "encyclopedia": ("Encyclopedia", "encyclopedia"), "clans": ("Clans", "clans"),
          "clanratings": ("ClanRatings", "clanRatings"), "globalmap": ("GlobalMap", "globalMap"),
          "stronghold": ("Stronghold", "stronghold"), "ratings": ("Ratings", "ratings")}
METHODS = {"list": "search", "claninfo": "clanInfo", "clanreserves": "clanReserves",
           "activateclanreserve": "activateClanReserve", "clanprovinces": "clanProvinces",
           "clanbattles": "clanBattles", "seasonclaninfo": "seasonClanInfo",
           "seasonaccountinfo": "seasonAccountInfo", "seasonrating": "seasonRating",
           "seasonratingneighbors": "seasonRatingNeighbors", "eventclaninfo": "eventClanInfo",
           "eventaccountinfo": "eventAccountInfo", "eventaccountratings": "eventAccountRatings",
           "eventaccountratingneighbors": "eventAccountRatingNeighbors", "eventrating": "eventRating",
           "eventratingneighbors": "eventRatingNeighbors", "vehicleprofile": "vehicleProfile",
           "vehicleprofiles": "vehicleProfiles", "personalmissions": "personalMissions",
           "crewroles": "crewRoles", "crewskills": "crewSkills", "tankinfo": "tankInfo",
           "tankengines": "tankEngines", "tankturrets": "tankTurrets", "tankradios": "tankRadios",
           "tankchassis": "tankChassis", "tankguns": "tankGuns", "accountinfo": "accountInfo",
           "messageboard": "messageboard", "memberhistory": "memberHistory"}


def parameter(name, schema):
    camel = name.split("_")[0] + "".join(p.title() for p in name.split("_")[1:])
    if name == "access_token":
        native = "AccessToken"
    elif ", list" in schema["type"]:
        native = "array"
        if name.endswith("_id"):
            camel += "s"
    elif schema["type"] == "numeric":
        native = "int"
    elif schema["type"] == "timestamp/date":
        native = "int|string"
    else:
        native = "string"
    required = schema["required"]
    doc = None
    if native == "array":
        doc = f"@param list<{'int' if schema['type'].startswith('numeric') else 'string'}> ${camel}"
    signature = f"{native} ${camel}" if required else (f"array ${camel} = []" if native == "array" else f"{native}|null ${camel} = null")
    if name == "access_token":
        signature = "#[SensitiveParameter] " + signature
    return name, camel, signature, doc


def generate_method(path, endpoint, operation="request", facade=False):
    section, slug = path.split("/")
    group, accessor = GROUPS[section]
    name = METHODS.get(slug, slug)
    if operation != "request":
        name = operation + name[0].upper() + name[1:]
    parameters = [(n, s) for n, s in endpoint["parameters"].items() if n != "application_id" and (operation == "request" or n != "page_no")]
    parameters.sort(key=lambda pair: not pair[1]["required"])
    args = [parameter(n, s) for n, s in parameters]
    signatures = [x[2] for x in args]
    docs = [x[3] for x in args if x[3]]
    if operation != "request":
        signatures += ["int $startPage = 1", "int $maxPages = 1000"]
    result_type = "Generator" if operation == "iterate" else "ApiResult"
    if operation == "iterate":
        docs.append("@return Generator<array-key, Record|null>")
    docs.insert(0, f"{path}; see the official reference linked in docs/ENDPOINTS.md.")
    if endpoint["deprecated"]:
        docs.append("@deprecated WG marks this endpoint deprecated; requires explicit client opt-in.")
    if endpoint["write"]:
        docs.append("Activates a real clan reserve. No automatic retries; a timeout has an unknown outcome.")
    lines = ["    /**"] + ["     * " + doc for doc in docs] + ["     */"]
    declaration = f"    public {'static ' if facade else ''}function {name}("
    if len(declaration + ", ".join(signatures)) > 110:
        lines.append(declaration)
        lines += ["        " + signature + "," for signature in signatures]
        lines.append(f"    ): {result_type}")
    else:
        lines.append(declaration + ", ".join(signatures) + f"): {result_type}")
    lines.append("    {")
    if facade:
        values = ["$" + x[1] for x in args]
        if operation != "request":
            values += ["$startPage", "$maxPages"]
        call = f"        return Wot::client()->{accessor}()->{name}("
        if len(call + ", ".join(values)) > 110:
            lines.append(call)
            lines += ["            " + value + "," for value in values]
            lines.append("        );")
        else:
            lines.append(call + ", ".join(values) + ");")
    else:
        token = next(("$" + x[1] for x in args if x[0] == "access_token"), "null")
        lines.append(f"        return $this->client->{operation}(")
        lines.append(f"            '{path}',")
        lines.append("            [")
        lines += [f"                '{x[0]}' => ${x[1]}," for x in args if x[0] != "access_token"]
        lines.append("            ],")
        lines.append(f"            {token},")
        if operation != "request":
            lines += ["            $startPage,", "            $maxPages,"]
        lines.append("        );")
    lines += ["    }", ""]
    return "\n".join(lines), name


table = ["# WoT endpoint coverage", "", "Contract snapshot: " + snapshot["checkedAt"] + ". Explicit PHP signatures are generated from the reviewed offline snapshot.", "",
         "65 data/operation methods are implemented below. The three auth methods are delegated to WgAuth AuthClient via WotClient::auth(). Deprecated methods require allowDeprecated: true; availability is not guaranteed. No other games are covered.", "",
         "| API path | Service method | Pagination | ID batch size | Status |", "| --- | --- | --- | --- | --- |"]
for section, (group, accessor) in GROUPS.items():
    for facade in [False, True]:
        namespace = "Facades" if facade else "Services"
        parts = ["<?php", "", "declare(strict_types=1);", "", f"namespace edrard\\WotClient\\{namespace};", "",
                 "use edrard\\WgAuth\\AccessToken;", "use edrard\\WotClient\\ApiResult;", "use edrard\\WotClient\\Record;", "use Generator;", "use SensitiveParameter;", "",
                 "/** Generated from resources/endpoints.json; regenerate with tools/generate-endpoints.py. */",
                 f"final {'class' if facade else 'readonly class'} {group}" + ("" if facade else " extends Service"), "{"]
        for path, endpoint in snapshot["endpoints"].items():
            if not path.startswith(section + "/"):
                continue
            body, name = generate_method(path, endpoint, facade=facade)
            parts.append(body)
            paged = "page_no" in endpoint["parameters"]
            if paged:
                for operation in ["iterate", "all"]:
                    parts.append(generate_method(path, endpoint, operation, facade)[0])
            if not facade:
                batch = endpoint["batchParameter"]
                size = endpoint["parameters"][batch]["maxItems"] if batch else "—"
                status = "Deprecated, opt-in" if endpoint["deprecated"] else ("Writes provider state" if endpoint["write"] else "Read")
                table.append(f"| [{path}](https://developers.wargaming.net/reference/all/wot/{path}/) | `{accessor}()->{name}()` | {'iterate/all' if paged else '—'} | {size} | {status} |")
        parts += ["}", ""]
        target = ROOT / "src" / namespace / f"{group}.php"
        target.parent.mkdir(parents=True, exist_ok=True)
        target.write_text("\n".join(parts), encoding="utf-8")
(ROOT / "docs").mkdir(exist_ok=True)
(ROOT / "docs/ENDPOINTS.md").write_text("\n".join(table) + "\n", encoding="utf-8")
print("Generated eight services, eight static facades and endpoint coverage.")
