<?php

declare(strict_types=1);

namespace edrard\WotClient;

use RuntimeException;

class ClientException extends RuntimeException
{
    public function __construct(string $message, public readonly ?int $providerCode = null, public readonly ?int $httpStatus = null)
    {
        parent::__construct($message);
    }
}
