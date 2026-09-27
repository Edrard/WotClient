<?php

declare(strict_types=1);

namespace edrard\WotClient\Http;

use edrard\WgApi\ApiConfiguration;
use edrard\WgApi\GetWgApi;
use edrard\WgApi\Realm;
use edrard\WgAuth\AccessToken;
use edrard\WgGetter\Contracts\DataGetterInterface;
use edrard\WgGetter\Contracts\RateLimiterInterface;
use edrard\WgGetter\Exceptions\InvalidResponseException as GetterInvalidResponse;
use edrard\WgGetter\Exceptions\RequestException;
use edrard\WgGetter\WgDataGetter;
use edrard\WgGetter\IntervalRateLimiter;
use edrard\WotClient\ClientException;
use edrard\WotClient\Contracts\BatchRequestExecutorInterface;
use edrard\WgGetter\Contracts\SingleAttemptDataGetterInterface;
use edrard\WotClient\PreparedOperation;
use edrard\WgGetter\RequestOutcome;
use edrard\WotClient\InvalidResponseException;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Utils;
use JsonException;
use SensitiveParameter;
use Throwable;

final class DefaultRequestExecutor implements BatchRequestExecutorInterface
{
    private GetWgApi $urls;
    private DataGetterInterface $getter;
    private ClientInterface $postClient;
    private RateLimiterInterface $limiter;

    /** @param array<string, string> $applicationIds */
    public function __construct(#[SensitiveParameter] private array $applicationIds, private string $language = 'en', ?DataGetterInterface $getter = null, ?ClientInterface $postClient = null, ?RateLimiterInterface $limiter = null)
    {
        $this->urls = new GetWgApi($applicationIds);
        $this->limiter = $limiter ?? new IntervalRateLimiter();
        $this->getter = $getter ?? new WgDataGetter(limiter: $this->limiter);
        $this->postClient = $postClient ?? new Client();
    }

    public function execute(Realm $realm, string $path, #[SensitiveParameter] array $parameters, #[SensitiveParameter] ?AccessToken $token = null, bool $write = false): array
    {
        $parameters['language'] ??= $this->language;
        if ($token === null && !$write) {
            [$section, $method] = explode('/', $path, 2);
            $this->getter->cleanUrls();
            try {
                $this->getter->setUrls(['request' => $this->urls->getUrl($realm->value, 'wot/'.$section, $method, $parameters)]);
                $envelopes = $this->getter->getEnvelopes();
                $envelope = $envelopes['request'] ?? null;
                if (!is_array($envelope)) {
                    throw new InvalidResponseException();
                }
                return $envelope;
            } catch (GetterInvalidResponse) {
                throw new InvalidResponseException();
            } catch (RequestException $exception) {
                throw new ClientException('WG GET request failed.', providerCode: $exception->getCode());
            } finally {
                $this->getter->cleanUrls();
            }
        }
        if ($token !== null) {
            $parameters['access_token'] = $token->value();
        }
        $configuration = new ApiConfiguration($this->applicationIds);
        $parameters['application_id'] = $configuration->applicationId($realm);
        foreach ($parameters as &$parameter) {
            if (is_array($parameter)) {
                $parameter = implode(',', $parameter);
            }
        }
        unset($parameter);
        $this->limiter->acquire(1);
        try {
            $response = $this->postClient->request('POST', $configuration->baseUrl($realm).'/wot/'.$path.'/', [
                'query' => [], 'debug' => false,
                'form_params' => $parameters, 'timeout' => 15, 'connect_timeout' => 5,
                'verify' => true, 'allow_redirects' => false, 'http_errors' => false,
                'headers' => ['Accept' => 'application/json'],
            ]);
            $status = $response->getStatusCode();
            $stream = $response->getBody();
            if ($stream->isSeekable()) {
                $stream->rewind();
            }
            $body = Utils::copyToString($stream);
        } catch (Throwable) {
            // Guzzle exceptions retain requests and credentials; never chain them.
            throw new ClientException('WG POST transport failed; the outcome may be unknown.');
        }
        if ($status < 200 || $status >= 300) {
            throw new ClientException('WG POST HTTP request failed.', httpStatus: $status);
        }
        try {
            $envelope = json_decode($body, true, 64, JSON_THROW_ON_ERROR);
        } catch (JsonException) {
            throw new InvalidResponseException();
        }
        if (!is_array($envelope)) {
            throw new InvalidResponseException();
        }
        return $envelope;
    }

    /** @param list<PreparedOperation> $requests @return array<int, RequestOutcome> */
    public function executeMany(#[SensitiveParameter] array $requests, int $concurrency): array
    {
        if (!$this->getter instanceof SingleAttemptDataGetterInterface) {
            throw new \LogicException('The getter does not support single-attempt multiget.');
        }
        $this->getter->cleanUrls();
        try {
            $urls = [];
            foreach ($requests as $key => $request) {
                $parameters = $request->parameters();
                $parameters['language'] ??= $this->language;
                $token = $request->token();
                if ($token !== null) {
                    $parameters['access_token'] = $token->value();
                }
                [$section, $method] = explode('/', $request->path, 2);
                $urls[$key] = $this->urls->getUrl($request->realm->value, 'wot/'.$section, $method, $parameters);
            }
            $this->getter->setUrls($urls);
            return $this->getter->getEnvelopeOutcomesOnce($concurrency);
        } finally {
            $this->getter->cleanUrls();
        }
    }

    /** @return array<string, string> */
    public function __debugInfo(): array
    {
        return ['credentials' => '[redacted]'];
    }
}
