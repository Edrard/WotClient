<?php

declare(strict_types=1);

namespace edrard\WotClient;

use Countable;
use Generator;
use SensitiveParameter;

final readonly class ApiResult implements Countable
{
    /**
     * @param array<array-key, mixed>|null $values
     * @param array<array-key, mixed> $meta
     * @param array<array-key, mixed> $envelope
     * @param list<ApiResult> $parts
     */
    public function __construct(#[SensitiveParameter] private ?array $values, public array $meta = [], #[SensitiveParameter] private array $envelope = [], public array $parts = [])
    {
    }

    /** @return array<array-key, mixed>|null */
    public function data(): ?array
    {
        return $this->values;
    }

    /** @return array<array-key, mixed> Original successful provider envelope. */
    public function envelope(): array
    {
        return $this->envelope;
    }

    public function count(): int
    {
        return is_array($this->values) ? count($this->values) : 0;
    }

    public function has(int|string $key): bool
    {
        return is_array($this->values) && array_key_exists($key, $this->values);
    }

    public function get(int|string $key): mixed
    {
        return is_array($this->values) ? ($this->values[$key] ?? null) : null;
    }

    /** For keyed records; list-valued entries such as account/tanks use get() instead. */
    public function record(int|string $key): ?Record
    {
        $value = $this->get($key);
        if ($value === null) {
            return null;
        }
        if (!is_array($value) || ($value !== [] && array_is_list($value))) {
            throw new InvalidResponseException();
        }
        return new Record($value);
    }

    /** For methods whose data is a single object, such as encyclopedia/info. */
    public function object(): ?Record
    {
        if ($this->values === null) {
            return null;
        }
        return new Record($this->values);
    }

    /** @return Generator<array-key, Record|null> */
    public function records(): Generator
    {
        foreach (is_array($this->values) ? $this->values : [] as $key => $value) {
            yield $key => $this->record($key);
        }
    }

    /** @return array<string, string|int> */
    public function __debugInfo(): array
    {
        return ['count' => $this->count(), 'data' => '[redacted]'];
    }
}
