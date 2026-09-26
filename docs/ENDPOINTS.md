# WoT endpoint coverage

Contract snapshot: 2026-09-27. Explicit PHP signatures are generated from the reviewed offline snapshot.

65 data/operation methods are implemented below. The three auth methods are delegated to WgAuth AuthClient via WotClient::auth(). Deprecated methods require allowDeprecated: true; availability is not guaranteed. No other games are covered.

| API path | Service method | Pagination | ID batch size | Status |
| --- | --- | --- | --- | --- |
| [account/list](https://developers.wargaming.net/reference/all/wot/account/list/) | `accounts()->search()` | — | — | Read |
| [account/info](https://developers.wargaming.net/reference/all/wot/account/info/) | `accounts()->info()` | — | 100 | Read |
| [account/tanks](https://developers.wargaming.net/reference/all/wot/account/tanks/) | `accounts()->tanks()` | — | 100 | Read |
| [account/achievements](https://developers.wargaming.net/reference/all/wot/account/achievements/) | `accounts()->achievements()` | — | 100 | Read |
| [account/wtr](https://developers.wargaming.net/reference/all/wot/account/wtr/) | `accounts()->wtr()` | — | 100 | Read |
| [tanks/stats](https://developers.wargaming.net/reference/all/wot/tanks/stats/) | `tanks()->stats()` | — | — | Read |
| [tanks/achievements](https://developers.wargaming.net/reference/all/wot/tanks/achievements/) | `tanks()->achievements()` | — | — | Read |
| [tanks/mastery](https://developers.wargaming.net/reference/all/wot/tanks/mastery/) | `tanks()->mastery()` | — | — | Read |
| [encyclopedia/tanks](https://developers.wargaming.net/reference/all/wot/encyclopedia/tanks/) | `encyclopedia()->tanks()` | — | — | Deprecated, opt-in |
| [encyclopedia/tankinfo](https://developers.wargaming.net/reference/all/wot/encyclopedia/tankinfo/) | `encyclopedia()->tankInfo()` | — | 1000 | Deprecated, opt-in |
| [encyclopedia/vehicles](https://developers.wargaming.net/reference/all/wot/encyclopedia/vehicles/) | `encyclopedia()->vehicles()` | iterate/all | — | Read |
| [encyclopedia/vehicleprofile](https://developers.wargaming.net/reference/all/wot/encyclopedia/vehicleprofile/) | `encyclopedia()->vehicleProfile()` | — | — | Read |
| [encyclopedia/tankengines](https://developers.wargaming.net/reference/all/wot/encyclopedia/tankengines/) | `encyclopedia()->tankEngines()` | — | — | Deprecated, opt-in |
| [encyclopedia/tankturrets](https://developers.wargaming.net/reference/all/wot/encyclopedia/tankturrets/) | `encyclopedia()->tankTurrets()` | — | — | Deprecated, opt-in |
| [encyclopedia/tankradios](https://developers.wargaming.net/reference/all/wot/encyclopedia/tankradios/) | `encyclopedia()->tankRadios()` | — | — | Deprecated, opt-in |
| [encyclopedia/tankchassis](https://developers.wargaming.net/reference/all/wot/encyclopedia/tankchassis/) | `encyclopedia()->tankChassis()` | — | — | Deprecated, opt-in |
| [encyclopedia/tankguns](https://developers.wargaming.net/reference/all/wot/encyclopedia/tankguns/) | `encyclopedia()->tankGuns()` | — | — | Deprecated, opt-in |
| [encyclopedia/achievements](https://developers.wargaming.net/reference/all/wot/encyclopedia/achievements/) | `encyclopedia()->achievements()` | — | — | Read |
| [encyclopedia/info](https://developers.wargaming.net/reference/all/wot/encyclopedia/info/) | `encyclopedia()->info()` | — | — | Read |
| [encyclopedia/arenas](https://developers.wargaming.net/reference/all/wot/encyclopedia/arenas/) | `encyclopedia()->arenas()` | — | — | Read |
| [encyclopedia/provisions](https://developers.wargaming.net/reference/all/wot/encyclopedia/provisions/) | `encyclopedia()->provisions()` | iterate/all | — | Read |
| [encyclopedia/personalmissions](https://developers.wargaming.net/reference/all/wot/encyclopedia/personalmissions/) | `encyclopedia()->personalMissions()` | — | — | Read |
| [encyclopedia/boosters](https://developers.wargaming.net/reference/all/wot/encyclopedia/boosters/) | `encyclopedia()->boosters()` | — | — | Read |
| [encyclopedia/vehicleprofiles](https://developers.wargaming.net/reference/all/wot/encyclopedia/vehicleprofiles/) | `encyclopedia()->vehicleProfiles()` | — | — | Read |
| [encyclopedia/modules](https://developers.wargaming.net/reference/all/wot/encyclopedia/modules/) | `encyclopedia()->modules()` | iterate/all | — | Read |
| [encyclopedia/badges](https://developers.wargaming.net/reference/all/wot/encyclopedia/badges/) | `encyclopedia()->badges()` | — | — | Read |
| [encyclopedia/crewroles](https://developers.wargaming.net/reference/all/wot/encyclopedia/crewroles/) | `encyclopedia()->crewRoles()` | — | — | Read |
| [encyclopedia/crewskills](https://developers.wargaming.net/reference/all/wot/encyclopedia/crewskills/) | `encyclopedia()->crewSkills()` | — | — | Read |
| [clans/list](https://developers.wargaming.net/reference/all/wot/clans/list/) | `clans()->search()` | iterate/all | — | Read |
| [clans/info](https://developers.wargaming.net/reference/all/wot/clans/info/) | `clans()->info()` | — | 100 | Read |
| [clans/accountinfo](https://developers.wargaming.net/reference/all/wot/clans/accountinfo/) | `clans()->accountInfo()` | — | 100 | Read |
| [clans/glossary](https://developers.wargaming.net/reference/all/wot/clans/glossary/) | `clans()->glossary()` | — | — | Read |
| [clans/messageboard](https://developers.wargaming.net/reference/all/wot/clans/messageboard/) | `clans()->messageboard()` | — | — | Read |
| [clans/memberhistory](https://developers.wargaming.net/reference/all/wot/clans/memberhistory/) | `clans()->memberHistory()` | — | — | Read |
| [clanratings/types](https://developers.wargaming.net/reference/all/wot/clanratings/types/) | `clanRatings()->types()` | — | — | Read |
| [clanratings/dates](https://developers.wargaming.net/reference/all/wot/clanratings/dates/) | `clanRatings()->dates()` | — | — | Read |
| [clanratings/clans](https://developers.wargaming.net/reference/all/wot/clanratings/clans/) | `clanRatings()->clans()` | — | 100 | Read |
| [clanratings/neighbors](https://developers.wargaming.net/reference/all/wot/clanratings/neighbors/) | `clanRatings()->neighbors()` | — | — | Read |
| [clanratings/top](https://developers.wargaming.net/reference/all/wot/clanratings/top/) | `clanRatings()->top()` | iterate/all | — | Read |
| [globalmap/fronts](https://developers.wargaming.net/reference/all/wot/globalmap/fronts/) | `globalMap()->fronts()` | iterate/all | — | Read |
| [globalmap/provinces](https://developers.wargaming.net/reference/all/wot/globalmap/provinces/) | `globalMap()->provinces()` | iterate/all | — | Read |
| [globalmap/claninfo](https://developers.wargaming.net/reference/all/wot/globalmap/claninfo/) | `globalMap()->clanInfo()` | — | 10 | Read |
| [globalmap/clanprovinces](https://developers.wargaming.net/reference/all/wot/globalmap/clanprovinces/) | `globalMap()->clanProvinces()` | — | 10 | Read |
| [globalmap/clanbattles](https://developers.wargaming.net/reference/all/wot/globalmap/clanbattles/) | `globalMap()->clanBattles()` | iterate/all | — | Read |
| [globalmap/seasons](https://developers.wargaming.net/reference/all/wot/globalmap/seasons/) | `globalMap()->seasons()` | iterate/all | — | Read |
| [globalmap/seasonclaninfo](https://developers.wargaming.net/reference/all/wot/globalmap/seasonclaninfo/) | `globalMap()->seasonClanInfo()` | — | — | Read |
| [globalmap/seasonaccountinfo](https://developers.wargaming.net/reference/all/wot/globalmap/seasonaccountinfo/) | `globalMap()->seasonAccountInfo()` | — | — | Read |
| [globalmap/seasonrating](https://developers.wargaming.net/reference/all/wot/globalmap/seasonrating/) | `globalMap()->seasonRating()` | iterate/all | — | Read |
| [globalmap/seasonratingneighbors](https://developers.wargaming.net/reference/all/wot/globalmap/seasonratingneighbors/) | `globalMap()->seasonRatingNeighbors()` | — | — | Read |
| [globalmap/events](https://developers.wargaming.net/reference/all/wot/globalmap/events/) | `globalMap()->events()` | iterate/all | — | Read |
| [globalmap/eventclaninfo](https://developers.wargaming.net/reference/all/wot/globalmap/eventclaninfo/) | `globalMap()->eventClanInfo()` | — | — | Read |
| [globalmap/eventaccountinfo](https://developers.wargaming.net/reference/all/wot/globalmap/eventaccountinfo/) | `globalMap()->eventAccountInfo()` | — | — | Read |
| [globalmap/eventaccountratings](https://developers.wargaming.net/reference/all/wot/globalmap/eventaccountratings/) | `globalMap()->eventAccountRatings()` | iterate/all | — | Read |
| [globalmap/eventaccountratingneighbors](https://developers.wargaming.net/reference/all/wot/globalmap/eventaccountratingneighbors/) | `globalMap()->eventAccountRatingNeighbors()` | iterate/all | — | Read |
| [globalmap/eventrating](https://developers.wargaming.net/reference/all/wot/globalmap/eventrating/) | `globalMap()->eventRating()` | iterate/all | — | Read |
| [globalmap/eventratingneighbors](https://developers.wargaming.net/reference/all/wot/globalmap/eventratingneighbors/) | `globalMap()->eventRatingNeighbors()` | — | — | Read |
| [globalmap/info](https://developers.wargaming.net/reference/all/wot/globalmap/info/) | `globalMap()->info()` | — | — | Read |
| [stronghold/claninfo](https://developers.wargaming.net/reference/all/wot/stronghold/claninfo/) | `stronghold()->clanInfo()` | — | 10 | Read |
| [stronghold/clanreserves](https://developers.wargaming.net/reference/all/wot/stronghold/clanreserves/) | `stronghold()->clanReserves()` | — | — | Read |
| [stronghold/activateclanreserve](https://developers.wargaming.net/reference/all/wot/stronghold/activateclanreserve/) | `stronghold()->activateClanReserve()` | — | — | Writes provider state |
| [ratings/types](https://developers.wargaming.net/reference/all/wot/ratings/types/) | `ratings()->types()` | — | — | Deprecated, opt-in |
| [ratings/dates](https://developers.wargaming.net/reference/all/wot/ratings/dates/) | `ratings()->dates()` | — | — | Deprecated, opt-in |
| [ratings/accounts](https://developers.wargaming.net/reference/all/wot/ratings/accounts/) | `ratings()->accounts()` | — | 100 | Deprecated, opt-in |
| [ratings/neighbors](https://developers.wargaming.net/reference/all/wot/ratings/neighbors/) | `ratings()->neighbors()` | — | — | Deprecated, opt-in |
| [ratings/top](https://developers.wargaming.net/reference/all/wot/ratings/top/) | `ratings()->top()` | iterate/all | — | Deprecated, opt-in |
