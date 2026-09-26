<?php

declare(strict_types=1);

namespace edrard\WotClient;

final class InvalidResponseException extends ClientException
{
    public function __construct()
    {
        parent::__construct('WG response does not match the expected contract.');
    }
}
