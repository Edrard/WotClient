<?php

declare(strict_types=1);

namespace edrard\WotClient;

use edrard\WgApi\Realm;

/** One WoT method invocation; client preparation captures the effective language before execution. */
final readonly class PreparedOperation
{
    /** @param array<string, mixed> $parameters */
    public function __construct(public Realm $realm, public string $path, #[\SensitiveParameter] private array $parameters, public ?int $batchSize = null)
    {
    }

    /** @return array<string, mixed> */
    public function parameters(): array
    {
        return $this->parameters;
    }

    /** @return array<string, string|int|null> */
    public function __debugInfo(): array
    {
        return ['realm' => $this->realm->value, 'path' => $this->path, 'parameters' => '[redacted]', 'batchSize' => $this->batchSize];
    }
}
