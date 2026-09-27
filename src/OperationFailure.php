<?php

declare(strict_types=1);

namespace edrard\WotClient;

/** Safe failure category; never stores a provider message, URL, body or previous exception. */
final readonly class OperationFailure
{
    public function __construct(public string $kind, public ?int $providerCode = null, public bool $retryable = false, public int $attempts = 1, public ?float $retryAfter = null)
    {
    }
}
