<?php

declare(strict_types=1);

namespace edrard\WotClient\Contracts;

use edrard\WgApi\Realm;
use edrard\WgAuth\AccessToken;
use SensitiveParameter;

interface RequestExecutorInterface
{
    /**
     * Return a WG envelope. Never log credentials, raw bodies or request URLs.
     * A write request must never be retried automatically.
     * @param array<string, mixed> $parameters
     * @return array<array-key, mixed>
     */
    public function execute(Realm $realm, string $path, array $parameters, #[SensitiveParameter] ?AccessToken $token = null, bool $write = false): array;
}
