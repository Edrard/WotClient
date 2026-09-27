<?php

declare(strict_types=1);

namespace edrard\WotClient;

use edrard\WgApi\Realm;
use edrard\WgAuth\AccessToken;

/** Immutable read operation; contains no URL or transport implementation. */
final readonly class PreparedOperation
{
    /** @param array<string, mixed> $parameters */
    public function __construct(public Realm $realm, public string $path, #[\SensitiveParameter] private array $parameters, #[\SensitiveParameter] private ?AccessToken $token = null)
    {
    }
    /** @return array<string, mixed> */
    public function parameters(): array
    {
        return $this->parameters;
    }
    public function token(): ?AccessToken
    {
        return $this->token;
    }
    /** @return array<string, string> */
    public function __debugInfo(): array
    {
        return ['realm' => $this->realm->value, 'path' => $this->path, 'parameters' => '[redacted]'];
    }
}
