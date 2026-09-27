<?php

declare(strict_types=1);

namespace edrard\WotClient\Contracts;

use edrard\WotClient\PreparedOperation;
use edrard\WgGetter\RequestOutcome;

interface BatchRequestExecutorInterface extends RequestExecutorInterface
{
    /** @param list<PreparedOperation> $requests Already split according to endpoint limits.
     * @return array<int, RequestOutcome>
     */
    public function executeMany(#[\SensitiveParameter] array $requests, int $concurrency): array;
}
