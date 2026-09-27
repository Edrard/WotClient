## Caller-sized batch preparation and execution

`WotClient::prepareBatch(string $path, array $values, int $batchSize, array $parameters = [], ?AccessToken $accessToken = null): array` returns `list<PreparedOperation>`. The static alternative is `Wot::prepareBatch` with identical arguments. It performs mechanical N/K splitting, including a final remainder, and never executes or retries requests. IDs use the endpoint batch parameter; exact account names use account/list/search. K must fit the documented provider maximum.

```php
$operations = $client->prepareBatch('account/info', range(1, 250), 25);
$outcomes = $client->executeMany($operations, 10);
$names = Wot::prepareBatch('account/list', ['PlayerOne', 'PlayerTwo'], 1);
$nameOutcomes = Wot::executeMany($names, 2);
```

`executeMany(array $operations, int $concurrency = 10): array` executes one attempt per wire request and returns keyed OperationOutcome objects. `OperationOutcome::failures(): array` exposes every safe part failure; `parts[i]->request` identifies its PreparedOperation, and `parts[i]->result()` exposes successful parts. `result()` on a failed outcome throws LogicException. Recovery belongs to the caller; no multiget retry cooldown is applied.
