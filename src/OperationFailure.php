<?php

declare(strict_types=1);

namespace edrard\WotClient;

/** Safe failure category; stores only an allowlisted WG identifier, never raw provider text. */
final readonly class OperationFailure
{
    public ?string $providerMessage;

    public function __construct(public string $kind, public ?int $providerCode = null, public bool $retryable = false, public int $attempts = 1, public ?float $retryAfter = null, ?string $providerMessage = null)
    {
        $this->providerMessage = in_array($providerMessage, [
            'INVALID_IP_ADDRESS', 'INVALID_APPLICATION_ID', 'APPLICATION_IS_BLOCKED',
            'REQUEST_LIMIT_EXCEEDED', 'SOURCE_NOT_AVAILABLE',
        ], true) ? $providerMessage : null;
    }
}
