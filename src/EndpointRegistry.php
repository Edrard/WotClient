<?php

declare(strict_types=1);

namespace edrard\WotClient;

use InvalidArgumentException;
use LogicException;

final class EndpointRegistry
{
    /** @var array<string, array<string, mixed>> */
    private array $endpoints;

    public function __construct()
    {
        $decoded = json_decode((string) file_get_contents(__DIR__.'/../resources/endpoints.json'), true, flags: JSON_THROW_ON_ERROR);
        if (!is_array($decoded) || !is_array($decoded['endpoints'] ?? null)) {
            throw new LogicException('Invalid bundled endpoint catalog.');
        }
        $this->endpoints = $decoded['endpoints'];
    }

    /** @return array<string, mixed> */
    public function get(string $path): array
    {
        return $this->endpoints[$path] ?? throw new InvalidArgumentException('Unknown WoT endpoint.');
    }

    /** @return list<string> */
    public function paths(): array
    {
        return array_keys($this->endpoints);
    }
}
