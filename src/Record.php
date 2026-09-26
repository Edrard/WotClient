<?php

declare(strict_types=1);

namespace edrard\WotClient;

use SensitiveParameter;

/** A partial provider record: absent fields and explicit null remain distinguishable. */
final readonly class Record
{
    /** @param array<array-key, mixed> $values */
    public function __construct(#[SensitiveParameter] private array $values)
    {
    }

    public function has(string $field): bool
    {
        return array_key_exists($field, $this->values);
    }

    public function get(string $field): mixed
    {
        return $this->values[$field] ?? null;
    }

    public function string(string $field): ?string
    {
        $value = $this->get($field);
        if ($value !== null && !is_string($value)) {
            throw new InvalidResponseException();
        }
        return $value;
    }

    public function integer(string $field): ?int
    {
        $value = $this->get($field);
        if ($value !== null && !is_int($value)) {
            throw new InvalidResponseException();
        }
        return $value;
    }

    public function boolean(string $field): ?bool
    {
        $value = $this->get($field);
        if ($value !== null && !is_bool($value)) {
            throw new InvalidResponseException();
        }
        return $value;
    }

    /**
     * Explicit access may include private data; consumers own its storage and logging policy.
     * @return array<array-key, mixed>
     */
    public function data(): array
    {
        return $this->values;
    }

    /** @return array<string, string> */
    public function __debugInfo(): array
    {
        return ['data' => '[redacted]'];
    }
}
