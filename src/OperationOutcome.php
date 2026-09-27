<?php

declare(strict_types=1);

namespace edrard\WotClient;

final readonly class OperationOutcome
{
    /** @param list<OperationOutcome> $parts Individual provider-limit chunks, available even on partial failure. */
    public function __construct(private ?ApiResult $value, public ?OperationFailure $failure = null, public array $parts = [], #[\SensitiveParameter] public ?PreparedOperation $request = null)
    {
        if (($value === null) === ($failure === null)) {
            throw new \InvalidArgumentException('Invalid operation outcome.');
        }
    }
    public function succeeded(): bool
    {
        return $this->failure === null;
    }
    /** @return list<OperationFailure> All failed wire requests; no sibling failure is discarded. */
    public function failures(): array
    {
        if ($this->parts === []) {
            return $this->failure === null ? [] : [$this->failure];
        }
        $failures = [];
        foreach ($this->parts as $part) {
            array_push($failures, ...$part->failures());
        }
        return $failures;
    }
    public function result(): ApiResult
    {
        return $this->value ?? throw new \LogicException('Operation did not complete successfully.');
    }
    /** @return array<string, mixed> */
    public function __debugInfo(): array
    {
        return ['succeeded' => $this->succeeded(), 'failure' => $this->failure, 'parts' => count($this->parts)];
    }
}
