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
     */
    public function __construct(#[SensitiveParameter] private ?array $values, public array $meta = [])
    {
    }

    /** @return array<array-key, mixed>|null */
    public function data(): ?array
    {
        return $this->values;
    }

    public function count(): int
    {
        return count($this->values ?? []);
    }

    public function has(int|string $key): bool
    {
        return array_key_exists($key, $this->values ?? []);
    }

    public function get(int|string $key): mixed
    {
        return $this->values[$key] ?? null;
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
        return $this->values === null ? null : new Record($this->values);
    }

    /** @return Generator<array-key, Record|null> */
    public function records(): Generator
    {
        foreach ($this->values ?? [] as $key => $value) {
            yield $key => $this->record($key);
        }
    }

    /** @return array<string, string|int> */
    public function __debugInfo(): array
    {
        return ['count' => $this->count(), 'data' => '[redacted]'];
    }
}
