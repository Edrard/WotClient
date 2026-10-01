<?php

declare(strict_types=1);

use edrard\WgGetter\RetryPolicy;
use edrard\WgGetter\WgDataGetter;
use edrard\WotClient\WotClient;

require __DIR__.'/../tests/bootstrap.php';

$id = getenv('WG_APPLICATION_ID') ?: throw new LogicException('Configure WG_APPLICATION_ID.');
// Keep the live smoke bounded; normal library defaults remain three attempts at 40/120 seconds.
$getter = new WgDataGetter(retry: new RetryPolicy(maxAttempts: 1), timeout: 10, connectTimeout: 5);
$client = new WotClient($id, getter: $getter);
$result = $client->encyclopedia()->info(fields: ['game_version'])[0];
$response = $result->body === null ? null : json_decode($result->body, true);
$wgStatus = is_array($response) ? ($response['status'] ?? null) : null;
echo json_encode(['http_status' => $result->httpStatus, 'wg_status' => $wgStatus, 'attempts' => $result->attempts], JSON_THROW_ON_ERROR).PHP_EOL;
exit($result->succeeded() && $wgStatus === 'ok' ? 0 : 1);
