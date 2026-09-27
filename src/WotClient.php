<?php

declare(strict_types=1);

namespace edrard\WotClient;

use edrard\WgApi\Realm;
use edrard\WgAuth\AccessToken;
use edrard\WgAuth\AuthClient;
use edrard\WotClient\Contracts\RequestExecutorInterface;
use edrard\WotClient\Http\DefaultRequestExecutor;
use Generator;
use InvalidArgumentException;
use SensitiveParameter;

/** Coordinates endpoint contracts; transports, authentication and collection pipelines remain separate. */
final class WotClient
{
    private EndpointRegistry $registry;
    private ParameterValidator $parameters;
    private ResponseValidator $responses;
    private RequestExecutorInterface $executor;
    private AuthClient $authentication;

    /** @param string|array<string, string> $applicationIds */
    public function __construct(
        #[SensitiveParameter] string|array $applicationIds,
        private Realm $realm = Realm::EU,
        private string $language = 'en',
        ?RequestExecutorInterface $executor = null,
        ?AuthClient $authentication = null,
        private bool $allowDeprecated = false,
    ) {
        $ids = is_string($applicationIds) ? array_fill_keys(['eu', 'na', 'asia'], $applicationIds) : $applicationIds;
        // Reuse WG's canonical realm/ID validation even with a custom executor.
        new \edrard\WgApi\ApiConfiguration($ids);
        $this->registry = new EndpointRegistry();
        $this->parameters = new ParameterValidator();
        $this->responses = new ResponseValidator();
        $this->executor = $executor ?? new DefaultRequestExecutor($ids, $language);
        $this->authentication = $authentication ?? new AuthClient($ids);
    }

    public function forRealm(Realm $realm): self
    {
        $client = clone $this;
        $client->realm = $realm;
        return $client;
    }

    /** Existing WgAuth methods: loginLocation(), prolongate(), logout(); each takes its explicit realm/token. */
    public function auth(): AuthClient
    {
        return $this->authentication;
    }

    public function accounts(): Services\Accounts
    {
        return new Services\Accounts($this);
    }
    public function tanks(): Services\Tanks
    {
        return new Services\Tanks($this);
    }
    public function encyclopedia(): Services\Encyclopedia
    {
        return new Services\Encyclopedia($this);
    }
    public function clans(): Services\Clans
    {
        return new Services\Clans($this);
    }
    public function clanRatings(): Services\ClanRatings
    {
        return new Services\ClanRatings($this);
    }
    public function globalMap(): Services\GlobalMap
    {
        return new Services\GlobalMap($this);
    }
    public function stronghold(): Services\Stronghold
    {
        return new Services\Stronghold($this);
    }
    public function ratings(): Services\Ratings
    {
        return new Services\Ratings($this);
    }

    /**
     * Only documented paths/parameters are accepted; the generated services provide named typed arguments.
     * @param array<string, mixed> $parameters
     */
    public function request(string $path, #[SensitiveParameter] array $parameters = [], #[SensitiveParameter] ?AccessToken $accessToken = null): ApiResult
    {
        [$endpoint, $batches] = $this->plan($path, $parameters, $accessToken);
        $parts = [];
        foreach ($batches as $batch) {
            $value = $this->responses->validate($endpoint, $this->executor->execute($this->realm, $path, $batch, $accessToken, $endpoint['write']));
            $this->combine($endpoint, [$batch], [$value]);
            $parts[] = $value;
        }
        return $this->combine($endpoint, $batches, $parts);
    }

    /** @param array<string, mixed> $parameters */
    public function prepare(string $path, #[SensitiveParameter] array $parameters = [], #[SensitiveParameter] ?AccessToken $accessToken = null): PreparedOperation
    {
        [$endpoint, , $parameters] = $this->plan($path, $parameters, $accessToken);
        if ($endpoint['write']) {
            throw new InvalidArgumentException('Concurrent operations are read-only; use the existing write method.');
        }
        return new PreparedOperation($this->realm, $path, $parameters, $accessToken);
    }

    /**
     * Mechanically split N values into caller-sized K requests, without execution or recovery.
     * Exact account-name searches use parameter search and type=exact.
     * @param array<array-key, int|string> $values
     * @param array<string, mixed> $parameters
     * @return list<PreparedOperation>
     */
    public function prepareBatch(string $path, #[SensitiveParameter] array $values, int $batchSize, #[SensitiveParameter] array $parameters = [], #[SensitiveParameter] ?AccessToken $accessToken = null): array
    {
        $endpoint = $this->registry->get($path);
        $names = $path === 'account/list';
        $parameter = $names ? 'search' : $endpoint['batchParameter'];
        $maximum = $names ? 100 : ($endpoint['parameters'][$parameter]['maxItems'] ?? null);
        if ($parameter === null || $batchSize < 1 || $maximum === null || $batchSize > $maximum || !array_is_list($values) || array_key_exists($parameter, $parameters)) {
            throw new InvalidArgumentException('Invalid batch parameter or size for this endpoint.');
        }
        $operations = [];
        foreach (array_chunk($values, $batchSize) as $chunk) {
            if ($names) {
                foreach ($chunk as $name) {
                    if (!is_string($name) || str_contains($name, ',')) {
                        throw new InvalidArgumentException('Expected individual exact account names.');
                    }
                }
                $parameters['type'] = 'exact';
            }
            $operations[] = $this->prepare($path, array_replace($parameters, [$parameter => $names ? implode(',', $chunk) : $chunk]), $accessToken);
        }
        return $operations;
    }

    /**
     * @param array<int|string, PreparedOperation> $operations
     * @return array<int|string, OperationOutcome>
     */
    public function executeMany(#[SensitiveParameter] array $operations, int $concurrency = 10): array
    {
        if ($concurrency < 1 || $concurrency > 10) {
            throw new InvalidArgumentException('Concurrency must be between 1 and 10.');
        }
        if ($operations === []) {
            return [];
        }
        if (!$this->executor instanceof \edrard\WotClient\Contracts\BatchRequestExecutorInterface) {
            throw new \LogicException('The injected executor does not support concurrent execution.');
        }
        $requests = [];
        $plans = [];
        foreach ($operations as $key => $operation) {
            $client = $this->forRealm($operation->realm);
            [$endpoint, $batches] = $client->plan($operation->path, $operation->parameters(), $operation->token());
            if ($endpoint['write']) {
                throw new InvalidArgumentException('Concurrent operations are read-only.');
            }
            $indices = [];
            foreach ($batches as $batch) {
                $indices[] = count($requests);
                $requests[] = new PreparedOperation($operation->realm, $operation->path, $batch, $operation->token());
            }
            $plans[$key] = [$endpoint, $batches, $indices];
        }
        $outcomes = $this->executor->executeMany($requests, $concurrency);
        if (array_keys($outcomes) !== array_keys($requests)) {
            throw new ClientException('Batch executor did not preserve request identities.');
        }
        $result = [];
        foreach ($plans as $key => [$endpoint, $batches, $indices]) {
            $parts = [];
            $values = [];
            $failure = null;
            foreach ($indices as $i) {
                $outcome = $outcomes[$i];
                if (!$outcome->succeeded()) {
                    $error = $outcome->failure;
                    $partFailure = new OperationFailure($error->kind, $error->code, $error->retryable, $outcome->attempts, $error->retryAfter);
                    $parts[] = new OperationOutcome(null, $partFailure, request: $requests[$i]);
                    $failure = $this->aggregateFailure($failure, $partFailure);
                    continue;
                }
                try {
                    $value = $this->responses->validate($endpoint, $outcome->envelope());
                    $this->combine($endpoint, [$batches[count($parts)]], [$value]);
                    $values[] = $value;
                    $parts[] = new OperationOutcome($value, request: $requests[$i]);
                } catch (ClientException $error) {
                    $partFailure = new OperationFailure('invalid_response', $error->providerCode, attempts: $outcome->attempts);
                    $parts[] = new OperationOutcome(null, $partFailure, request: $requests[$i]);
                    $failure = $this->aggregateFailure($failure, $partFailure);
                }
            }
            $result[$key] = $failure === null ? new OperationOutcome($this->combine($endpoint, $batches, $values), parts: $parts) : new OperationOutcome(null, $failure, $parts);
        }
        return $result;
    }

    private function aggregateFailure(?OperationFailure $previous, OperationFailure $next): OperationFailure
    {
        if ($previous === null) {
            return $next;
        }
        $selected = !$next->retryable && $previous->retryable ? $next : $previous;
        $retryAfter = $previous->retryAfter === null && $next->retryAfter === null ? null : max($previous->retryAfter ?? 0.0, $next->retryAfter ?? 0.0);
        return new OperationFailure($selected->kind, $selected->providerCode, $previous->retryable && $next->retryable, max($previous->attempts, $next->attempts), $retryAfter);
    }

    /**
     * @param array<string, mixed> $parameters
     * @return array{array<string, mixed>, list<array<string, mixed>>, array<string, mixed>}
     */
    private function plan(string $path, #[SensitiveParameter] array $parameters, #[SensitiveParameter] ?AccessToken $accessToken): array
    {
        $endpoint = $this->registry->get($path);
        if (!in_array($this->realm->value, $endpoint['realms'], true)) {
            throw new InvalidArgumentException('This endpoint is unavailable in the selected realm.');
        }
        if ($endpoint['deprecated'] && !$this->allowDeprecated) {
            throw new ClientException('WG has deprecated this endpoint; explicit opt-in is required.');
        }
        $tokenAllowed = isset($endpoint['parameters']['access_token']);
        if ($accessToken !== null && (!$tokenAllowed || $accessToken->realm !== $this->realm || $accessToken->expiresAt <= time())) {
            throw new InvalidArgumentException('Token is unsupported, expired or belongs to another realm.');
        }
        if (($endpoint['parameters']['access_token']['required'] ?? false) && $accessToken === null) {
            throw new InvalidArgumentException('An access token is required.');
        }
        $endpoint['hasToken'] = $accessToken !== null;
        if (isset($endpoint['parameters']['language'])) {
            $parameters['language'] ??= $this->language;
        }
        $parameters = $this->parameters->validate($endpoint, $parameters);
        $batchParameter = $endpoint['batchParameter'];
        $batches = [$parameters];
        if ($batchParameter !== null) {
            $batches = [];
            foreach (array_chunk($parameters[$batchParameter], $endpoint['parameters'][$batchParameter]['maxItems']) as $chunk) {
                $batches[] = array_replace($parameters, [$batchParameter => $chunk]);
            }
        }
        return [$endpoint, $batches, $parameters];
    }

    /**
     * @param array<string, mixed> $endpoint
     * @param list<array<string, mixed>> $batches
     * @param list<ApiResult> $parts
     */
    private function combine(array $endpoint, #[SensitiveParameter] array $batches, array $parts): ApiResult
    {
        $data = [];
        $metadata = [];
        foreach ($parts as $i => $result) {
            $batchParameter = $endpoint['batchParameter'];
            if ($batchParameter !== null) {
                $values = $result->data();
                $ids = $batches[$i][$batchParameter];
                if ($values === null || array_diff(array_keys($values), $ids) !== [] || array_diff($ids, array_keys($values)) !== []) {
                    throw new InvalidResponseException();
                }
                foreach ($values as $key => $value) {
                    if (array_key_exists($key, $data) || (is_array($value) && isset($value[$batchParameter]) && $value[$batchParameter] !== (int) $key)) {
                        throw new InvalidResponseException();
                    }
                    $data[$key] = $value;
                }
            }
            $metadata[] = $result->meta;
        }
        if (count($parts) === 1) {
            return $parts[0];
        }
        return new ApiResult($data, ['count' => count($data), 'batches' => $metadata]);
    }

    /**
     * Lazy pages. Metadata is checked; without page_total we continue until an empty page.
     * A safety limit raises an exception instead of silently returning incomplete data.
     * @param array<string, mixed> $parameters
     * @return Generator<int, ApiResult>
     */
    public function pages(string $path, array $parameters = [], #[SensitiveParameter] ?AccessToken $accessToken = null, int $startPage = 1, int $maxPages = 1000): Generator
    {
        $endpoint = $this->registry->get($path);
        if (!isset($endpoint['parameters']['page_no']) || $startPage < 1 || $maxPages < 1 || $maxPages > 100000 || $startPage > PHP_INT_MAX - $maxPages) {
            throw new InvalidArgumentException('Unsupported pagination or invalid page bounds.');
        }
        if ($endpoint['batchParameter'] !== null) {
            throw new InvalidArgumentException('Pagination cannot be combined with automatic ID batching.');
        }
        $previous = null;
        for ($offset = 0; $offset < $maxPages; ++$offset) {
            $page = $startPage + $offset;
            $result = $this->request($path, array_replace($parameters, ['page_no' => $page]), $accessToken);
            $total = $result->meta['page_total'] ?? null;
            foreach (['page_no', 'page'] as $field) {
                if (array_key_exists($field, $result->meta) && $result->meta[$field] !== $page) {
                    throw new InvalidResponseException();
                }
            }
            if ($total !== null && (!is_int($total) || $total < 0)) {
                throw new InvalidResponseException();
            }
            if ($result->count() === 0) {
                if ($total !== null && $page < $total) {
                    throw new InvalidResponseException();
                }
                return;
            }
            if ($total !== null && $page > $total) {
                throw new InvalidResponseException();
            }
            $fingerprint = hash('sha256', json_encode($result->data(), JSON_THROW_ON_ERROR));
            if ($fingerprint === $previous) {
                throw new ClientException('WG repeated a pagination page.');
            }
            $previous = $fingerprint;
            yield $page => $result;
            if ($total !== null && $page >= $total) {
                return;
            }
        }
        throw new ClientException('Pagination safety limit reached; the result is incomplete.');
    }

    /**
     * @param array<string, mixed> $parameters
     * @return Generator<array-key, Record|null>
     */
    public function iterate(string $path, array $parameters = [], #[SensitiveParameter] ?AccessToken $accessToken = null, int $startPage = 1, int $maxPages = 1000): Generator
    {
        $position = 0;
        foreach ($this->pages($path, $parameters, $accessToken, $startPage, $maxPages) as $page) {
            $list = array_is_list($page->data() ?? []);
            foreach ($page->records() as $key => $record) {
                yield ($list ? $position++ : $key) => $record;
            }
        }
    }

    /** @param array<string, mixed> $parameters */
    public function all(string $path, array $parameters = [], #[SensitiveParameter] ?AccessToken $accessToken = null, int $startPage = 1, int $maxPages = 1000): ApiResult
    {
        $all = [];
        $pages = 0;
        foreach ($this->pages($path, $parameters, $accessToken, $startPage, $maxPages) as $result) {
            ++$pages;
            $data = $result->data() ?? [];
            if (array_is_list($data)) {
                array_push($all, ...$data);
            } else {
                foreach ($data as $key => $record) {
                    if (array_key_exists($key, $all)) {
                        throw new ClientException('WG returned duplicate record keys across pages.');
                    }
                    $all[$key] = $record;
                }
            }
        }
        return new ApiResult($all, ['count' => count($all), 'pages' => $pages]);
    }

    /** @return array<string, string> */
    public function __debugInfo(): array
    {
        return ['realm' => $this->realm->value, 'language' => $this->language, 'credentials' => '[redacted]'];
    }
}
