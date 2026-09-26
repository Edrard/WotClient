<?php

declare(strict_types=1);

namespace edrard\WotClient\Services;

use edrard\WotClient\WotClient;

abstract readonly class Service
{
    public function __construct(protected WotClient $client)
    {
    }
}
