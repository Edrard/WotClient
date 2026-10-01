<?php

declare(strict_types=1);

use edrard\WotClient\Facades\Accounts;
use edrard\WotClient\Facades\Wot;
use edrard\WotClient\WotClient;

require __DIR__.'/../vendor/autoload.php';

$id = getenv('WG_APPLICATION_ID') ?: throw new LogicException('Configure WG_APPLICATION_ID.');
$client = new WotClient($id);
Wot::configure($client);
try {
    if (!in_array('--run', $argv, true)) {
        echo 'Client configured; pass --run to send a public GET.'.PHP_EOL;
        exit(0);
    }
    $result = Accounts::info([500000001], batchSize: 1, fields: ['account_id'])[0];
    echo json_encode(['http_status' => $result->httpStatus, 'attempts' => $result->attempts], JSON_THROW_ON_ERROR).PHP_EOL;
} finally {
    Wot::reset();
}
