# World of Tanks GET endpoint catalog

Snapshot: 2026-09-27. Authentication is handled independently by WgAuth. POST methods are outside this GET client.

Deprecated methods remain callable; the label does not establish their current availability at WG.

| Path | Instance method | K required | Deprecated |
| --- | --- | --- | --- |
| [account/list](https://developers.wargaming.net/reference/all/wot/account/list/) | `accounts()->search()` | No | No |
| [account/info](https://developers.wargaming.net/reference/all/wot/account/info/) | `accounts()->info()` | Yes | No |
| [account/tanks](https://developers.wargaming.net/reference/all/wot/account/tanks/) | `accounts()->tanks()` | Yes | No |
| [account/achievements](https://developers.wargaming.net/reference/all/wot/account/achievements/) | `accounts()->achievements()` | Yes | No |
| [account/wtr](https://developers.wargaming.net/reference/all/wot/account/wtr/) | `accounts()->wtr()` | Yes | No |
| [tanks/stats](https://developers.wargaming.net/reference/all/wot/tanks/stats/) | `tanks()->stats()` | No | No |
| [tanks/achievements](https://developers.wargaming.net/reference/all/wot/tanks/achievements/) | `tanks()->achievements()` | No | No |
| [tanks/mastery](https://developers.wargaming.net/reference/all/wot/tanks/mastery/) | `tanks()->mastery()` | No | No |
| [encyclopedia/tanks](https://developers.wargaming.net/reference/all/wot/encyclopedia/tanks/) | `encyclopedia()->tanks()` | No | **Deprecated** |
| [encyclopedia/tankinfo](https://developers.wargaming.net/reference/all/wot/encyclopedia/tankinfo/) | `encyclopedia()->tankInfo()` | Yes | **Deprecated** |
| [encyclopedia/vehicles](https://developers.wargaming.net/reference/all/wot/encyclopedia/vehicles/) | `encyclopedia()->vehicles()` | No | No |
| [encyclopedia/vehicleprofile](https://developers.wargaming.net/reference/all/wot/encyclopedia/vehicleprofile/) | `encyclopedia()->vehicleProfile()` | No | No |
| [encyclopedia/tankengines](https://developers.wargaming.net/reference/all/wot/encyclopedia/tankengines/) | `encyclopedia()->tankEngines()` | No | **Deprecated** |
| [encyclopedia/tankturrets](https://developers.wargaming.net/reference/all/wot/encyclopedia/tankturrets/) | `encyclopedia()->tankTurrets()` | No | **Deprecated** |
| [encyclopedia/tankradios](https://developers.wargaming.net/reference/all/wot/encyclopedia/tankradios/) | `encyclopedia()->tankRadios()` | No | **Deprecated** |
| [encyclopedia/tankchassis](https://developers.wargaming.net/reference/all/wot/encyclopedia/tankchassis/) | `encyclopedia()->tankChassis()` | No | **Deprecated** |
| [encyclopedia/tankguns](https://developers.wargaming.net/reference/all/wot/encyclopedia/tankguns/) | `encyclopedia()->tankGuns()` | No | **Deprecated** |
| [encyclopedia/achievements](https://developers.wargaming.net/reference/all/wot/encyclopedia/achievements/) | `encyclopedia()->achievements()` | No | No |
| [encyclopedia/info](https://developers.wargaming.net/reference/all/wot/encyclopedia/info/) | `encyclopedia()->info()` | No | No |
| [encyclopedia/arenas](https://developers.wargaming.net/reference/all/wot/encyclopedia/arenas/) | `encyclopedia()->arenas()` | No | No |
| [encyclopedia/provisions](https://developers.wargaming.net/reference/all/wot/encyclopedia/provisions/) | `encyclopedia()->provisions()` | No | No |
| [encyclopedia/personalmissions](https://developers.wargaming.net/reference/all/wot/encyclopedia/personalmissions/) | `encyclopedia()->personalMissions()` | No | No |
| [encyclopedia/boosters](https://developers.wargaming.net/reference/all/wot/encyclopedia/boosters/) | `encyclopedia()->boosters()` | No | No |
| [encyclopedia/vehicleprofiles](https://developers.wargaming.net/reference/all/wot/encyclopedia/vehicleprofiles/) | `encyclopedia()->vehicleProfiles()` | No | No |
| [encyclopedia/modules](https://developers.wargaming.net/reference/all/wot/encyclopedia/modules/) | `encyclopedia()->modules()` | No | No |
| [encyclopedia/badges](https://developers.wargaming.net/reference/all/wot/encyclopedia/badges/) | `encyclopedia()->badges()` | No | No |
| [encyclopedia/crewroles](https://developers.wargaming.net/reference/all/wot/encyclopedia/crewroles/) | `encyclopedia()->crewRoles()` | No | No |
| [encyclopedia/crewskills](https://developers.wargaming.net/reference/all/wot/encyclopedia/crewskills/) | `encyclopedia()->crewSkills()` | No | No |
| [clans/list](https://developers.wargaming.net/reference/all/wot/clans/list/) | `clans()->search()` | No | No |
| [clans/info](https://developers.wargaming.net/reference/all/wot/clans/info/) | `clans()->info()` | Yes | No |
| [clans/accountinfo](https://developers.wargaming.net/reference/all/wot/clans/accountinfo/) | `clans()->accountInfo()` | Yes | No |
| [clans/glossary](https://developers.wargaming.net/reference/all/wot/clans/glossary/) | `clans()->glossary()` | No | No |
| [clans/messageboard](https://developers.wargaming.net/reference/all/wot/clans/messageboard/) | `clans()->messageboard()` | No | No |
| [clans/memberhistory](https://developers.wargaming.net/reference/all/wot/clans/memberhistory/) | `clans()->memberHistory()` | No | No |
| [clanratings/types](https://developers.wargaming.net/reference/all/wot/clanratings/types/) | `clanRatings()->types()` | No | No |
| [clanratings/dates](https://developers.wargaming.net/reference/all/wot/clanratings/dates/) | `clanRatings()->dates()` | No | No |
| [clanratings/clans](https://developers.wargaming.net/reference/all/wot/clanratings/clans/) | `clanRatings()->clans()` | Yes | No |
| [clanratings/neighbors](https://developers.wargaming.net/reference/all/wot/clanratings/neighbors/) | `clanRatings()->neighbors()` | No | No |
| [clanratings/top](https://developers.wargaming.net/reference/all/wot/clanratings/top/) | `clanRatings()->top()` | No | No |
| [globalmap/fronts](https://developers.wargaming.net/reference/all/wot/globalmap/fronts/) | `globalMap()->fronts()` | No | No |
| [globalmap/provinces](https://developers.wargaming.net/reference/all/wot/globalmap/provinces/) | `globalMap()->provinces()` | No | No |
| [globalmap/claninfo](https://developers.wargaming.net/reference/all/wot/globalmap/claninfo/) | `globalMap()->clanInfo()` | Yes | No |
| [globalmap/clanprovinces](https://developers.wargaming.net/reference/all/wot/globalmap/clanprovinces/) | `globalMap()->clanProvinces()` | Yes | No |
| [globalmap/clanbattles](https://developers.wargaming.net/reference/all/wot/globalmap/clanbattles/) | `globalMap()->clanBattles()` | No | No |
| [globalmap/seasons](https://developers.wargaming.net/reference/all/wot/globalmap/seasons/) | `globalMap()->seasons()` | No | No |
| [globalmap/seasonclaninfo](https://developers.wargaming.net/reference/all/wot/globalmap/seasonclaninfo/) | `globalMap()->seasonClanInfo()` | No | No |
| [globalmap/seasonaccountinfo](https://developers.wargaming.net/reference/all/wot/globalmap/seasonaccountinfo/) | `globalMap()->seasonAccountInfo()` | No | No |
| [globalmap/seasonrating](https://developers.wargaming.net/reference/all/wot/globalmap/seasonrating/) | `globalMap()->seasonRating()` | No | No |
| [globalmap/seasonratingneighbors](https://developers.wargaming.net/reference/all/wot/globalmap/seasonratingneighbors/) | `globalMap()->seasonRatingNeighbors()` | No | No |
| [globalmap/events](https://developers.wargaming.net/reference/all/wot/globalmap/events/) | `globalMap()->events()` | No | No |
| [globalmap/eventclaninfo](https://developers.wargaming.net/reference/all/wot/globalmap/eventclaninfo/) | `globalMap()->eventClanInfo()` | No | No |
| [globalmap/eventaccountinfo](https://developers.wargaming.net/reference/all/wot/globalmap/eventaccountinfo/) | `globalMap()->eventAccountInfo()` | No | No |
| [globalmap/eventaccountratings](https://developers.wargaming.net/reference/all/wot/globalmap/eventaccountratings/) | `globalMap()->eventAccountRatings()` | No | No |
| [globalmap/eventaccountratingneighbors](https://developers.wargaming.net/reference/all/wot/globalmap/eventaccountratingneighbors/) | `globalMap()->eventAccountRatingNeighbors()` | No | No |
| [globalmap/eventrating](https://developers.wargaming.net/reference/all/wot/globalmap/eventrating/) | `globalMap()->eventRating()` | No | No |
| [globalmap/eventratingneighbors](https://developers.wargaming.net/reference/all/wot/globalmap/eventratingneighbors/) | `globalMap()->eventRatingNeighbors()` | No | No |
| [globalmap/info](https://developers.wargaming.net/reference/all/wot/globalmap/info/) | `globalMap()->info()` | No | No |
| [stronghold/claninfo](https://developers.wargaming.net/reference/all/wot/stronghold/claninfo/) | `stronghold()->clanInfo()` | Yes | No |
| [stronghold/clanreserves](https://developers.wargaming.net/reference/all/wot/stronghold/clanreserves/) | `stronghold()->clanReserves()` | No | No |
| [ratings/types](https://developers.wargaming.net/reference/all/wot/ratings/types/) | `ratings()->types()` | No | **Deprecated** |
| [ratings/dates](https://developers.wargaming.net/reference/all/wot/ratings/dates/) | `ratings()->dates()` | No | **Deprecated** |
| [ratings/accounts](https://developers.wargaming.net/reference/all/wot/ratings/accounts/) | `ratings()->accounts()` | Yes | **Deprecated** |
| [ratings/neighbors](https://developers.wargaming.net/reference/all/wot/ratings/neighbors/) | `ratings()->neighbors()` | No | **Deprecated** |
| [ratings/top](https://developers.wargaming.net/reference/all/wot/ratings/top/) | `ratings()->top()` | No | **Deprecated** |
