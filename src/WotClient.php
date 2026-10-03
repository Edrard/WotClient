<?php

declare(strict_types=1);

namespace edrard\WotClient;

use edrard\WgApi\ApiConfiguration;
use edrard\WgApi\GetWgApi;
use edrard\WgApi\Realm;
use edrard\WgApi\UrlBuilderInterface;
use edrard\WgGetter\Contracts\DataGetterInterface;
use edrard\WgGetter\FetchResult;
use edrard\WgGetter\WgDataGetter;
use InvalidArgumentException;
use LogicException;
use SensitiveParameter;

/** Prepares WoT GET calls and passes the getter's raw results through unchanged. */
final class WotClient
{
    private EndpointRegistry $registry;
    private ParameterValidator $validator;
    private UrlBuilderInterface $urls;
    private DataGetterInterface $getter;

    /** @param string|array<string, string> $applicationIds */
    public function __construct(
        #[SensitiveParameter] string|array $applicationIds,
        private Realm $realm = Realm::EU,
        private string $language = 'en',
        ?UrlBuilderInterface $urls = null,
        ?DataGetterInterface $getter = null,
    ) {
        $ids = is_string($applicationIds) ? array_fill_keys(['eu', 'na', 'asia'], $applicationIds) : $applicationIds;
        new ApiConfiguration($ids);
        $this->urls = $urls ?? new GetWgApi($ids);
        $this->getter = $getter ?? new WgDataGetter();
        $this->registry = new EndpointRegistry();
        $this->validator = new ParameterValidator();
    }

    public function forRealm(Realm $realm): self
    {
        $client = clone $this;
        $client->realm = $realm;
        return $client;
    }

    /** Changes the default for future requests and preparations on this client. */
    public function setLanguage(string $language): void
    {
        $this->language = $language;
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
     * One invocation yields one raw FetchResult per generated URL, even when only one URL is needed.
     * @param array<string, mixed> $parameters
     * @return list<FetchResult>
     */
    public function request(string $path, #[SensitiveParameter] array $parameters = [], ?int $batchSize = null): array
    {
        return $this->executeMany(['request' => $this->prepare($path, $parameters, $batchSize)])['request'];
    }

    /** @param array<string, mixed> $parameters */
    public function prepare(string $path, #[SensitiveParameter] array $parameters = [], ?int $batchSize = null): PreparedOperation
    {
        $parameters = $this->withDefaultLanguage($this->registry->get($path), $parameters);
        $operation = new PreparedOperation($this->realm, $path, $parameters, $batchSize);
        $this->urlsFor($operation);
        return $operation;
    }

    /**
     * Mixed methods and realms run in one getter multirequest. No result body is parsed or merged.
     * @param array<int|string, mixed> $operations
     * @return array<int|string, list<FetchResult>>
     */
    public function executeMany(#[SensitiveParameter] array $operations): array
    {
        if ($operations === []) {
            return [];
        }
        $urls = [];
        $indices = [];
        foreach ($operations as $key => $operation) {
            if (!$operation instanceof PreparedOperation) {
                throw new InvalidArgumentException('Expected prepared WoT operations.');
            }
            $indices[$key] = [];
            foreach ($this->urlsFor($operation) as $url) {
                $index = count($urls);
                $urls[$index] = $url;
                $indices[$key][] = $index;
            }
        }
        $raw = [];
        if ($urls !== []) {
            $this->getter->setUrls($urls);
            $raw = $this->getter->getData();
        }
        $result = [];
        foreach ($indices as $key => $parts) {
            $result[$key] = [];
            foreach ($parts as $index) {
                $result[$key][] = $raw[$index] ?? throw new LogicException('Getter omitted a request result.');
            }
        }
        return $result;
    }

    /** @return list<string> */
    private function urlsFor(PreparedOperation $operation): array
    {
        $endpoint = $this->registry->get($operation->path);
        if ($endpoint['write'] || !in_array('GET', $endpoint['httpMethods'], true)) {
            throw new InvalidArgumentException('This operation is not an HTTP GET method.');
        }
        if (!in_array($operation->realm->value, $endpoint['realms'], true)) {
            throw new InvalidArgumentException('This endpoint is unavailable in the selected realm.');
        }
        $parameters = $this->withDefaultLanguage($endpoint, $operation->parameters());
        if ($operation->path === 'account/list' && is_array($parameters['search'] ?? null)) {
            if (($parameters['type'] ?? 'exact') !== 'exact') {
                throw new InvalidArgumentException('Nickname batches require type=exact; use separate search operations for startswith.');
            }
            if ($operation->batchSize === null || $operation->batchSize < 1 || !array_is_list($parameters['search']) || $parameters['search'] === []) {
                throw new InvalidArgumentException('Supply names and a positive K for exact nickname batching.');
            }
            $urls = [];
            $parameters['type'] = 'exact';
            foreach (array_chunk($parameters['search'], $operation->batchSize) as $names) {
                foreach ($names as $name) {
                    if (!is_string($name) || str_contains($name, ',')) {
                        throw new InvalidArgumentException('Exact nicknames must be strings without commas.');
                    }
                }
                $chunk = $this->validator->validate($endpoint, array_replace($parameters, ['search' => implode(',', $names)]));
                $urls[] = $this->urls->getUrl($operation->realm->value, 'wot', $operation->path, $chunk);
            }
            return $urls;
        }
        $endpoint['hasToken'] = isset($parameters['access_token']);
        $parameters = $this->validator->validate($endpoint, $parameters);
        $batchParameter = $endpoint['batchParameter'];
        if ($batchParameter === null) {
            if ($operation->batchSize !== null) {
                throw new InvalidArgumentException('This method does not accept a batch size.');
            }
            return [$this->urls->getUrl($operation->realm->value, 'wot', $operation->path, $parameters)];
        }
        if ($operation->batchSize === null || $operation->batchSize < 1) {
            throw new InvalidArgumentException('Supply a positive K for an ID-list method.');
        }
        $urls = [];
        foreach (array_chunk($parameters[$batchParameter], $operation->batchSize) as $ids) {
            $chunk = array_replace($parameters, [$batchParameter => $ids]);
            $urls[] = $this->urls->getUrl($operation->realm->value, 'wot', $operation->path, $chunk);
        }
        return $urls;
    }

    /**
     * @param array<string, mixed> $endpoint
     * @param array<string, mixed> $parameters
     * @return array<string, mixed>
     */
    private function withDefaultLanguage(array $endpoint, #[SensitiveParameter] array $parameters): array
    {
        if (isset($endpoint['parameters']['language'])) {
            $parameters['language'] ??= $this->language;
        }
        return $parameters;
    }

    /** @return array<string, string> */
    public function __debugInfo(): array
    {
        return ['credentials' => '[redacted]'];
    }
}
