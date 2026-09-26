<?php

declare(strict_types=1);

namespace edrard\Tests\WotClient\Fixtures;

use Closure;
use edrard\WgApi\Realm;
use edrard\WgAuth\AccessToken;
use edrard\WotClient\Contracts\RequestExecutorInterface;

final class RecordingExecutor implements RequestExecutorInterface
{
    public array $calls = [];
    private Closure $respond;

    public function __construct(?callable $respond = null)
    {
        $this->respond = $respond === null ? static fn (): array => ['status' => 'ok', 'data' => [], 'meta' => []] : Closure::fromCallable($respond);
    }

    public function execute(Realm $realm, string $path, array $parameters, ?AccessToken $token = null, bool $write = false): array
    {
        $this->calls[] = compact('realm', 'path', 'parameters', 'token', 'write');
        return ($this->respond)($realm, $path, $parameters, $token, $write);
    }
}
