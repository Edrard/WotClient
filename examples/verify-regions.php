<?php

declare(strict_types=1);

use edrard\WgApi\Realm;
use edrard\WgGetter\RetryPolicy;
use edrard\WgGetter\WgDataGetter;
use edrard\WotClient\WotClient;

require __DIR__.'/../tests/bootstrap.php';

$id = getenv('WG_APPLICATION_ID') ?: throw new LogicException('Configure WG_APPLICATION_ID.');
$getter = new WgDataGetter(retry: new RetryPolicy(maxAttempts: 1), timeout: 10, connectTimeout: 5);
$client = new WotClient($id, getter: $getter);
$operations = [];
foreach ([Realm::EU, Realm::NA, Realm::ASIA] as $realm) {
    $operations[$realm->value] = $client->forRealm($realm)->encyclopedia()->prepareInfo(fields: ['game_version']);
}
$results = $client->executeMany($operations);
$failed = false;
foreach ($results as $realm => $parts) {
    $result = $parts[0];
    $response = $result->body === null ? null : json_decode($result->body, true);
    $wgStatus = is_array($response) ? ($response['status'] ?? null) : null;
    $failed = $failed || !$result->succeeded() || $wgStatus !== 'ok';
    echo json_encode([
        'realm' => $realm,
        'http_status' => $result->httpStatus,
        'wg_status' => $wgStatus,
        'attempts' => $result->attempts,
    ], JSON_THROW_ON_ERROR).PHP_EOL;
}
exit($failed ? 1 : 0);
