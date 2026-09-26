<?php

declare(strict_types=1);

use edrard\WgApi\Realm;
use edrard\WotClient\Facades\Accounts;
use edrard\WotClient\Facades\Wot;
use edrard\WotClient\WotClient;

require __DIR__.'/../vendor/autoload.php';
$id = getenv('WG_APPLICATION_ID') ?: throw new LogicException('Configure WG_APPLICATION_ID.');
$client = new WotClient($id, Realm::EU);
unset($id);
// Construction only: invoking the methods below would perform API requests.
Wot::configure($client);
try {
    if (in_array('--run', $argv, true)) {
        $result = Accounts::info([500000001], fields: ['account_id', 'nickname']);
        echo 'Returned entries: '.count($result).PHP_EOL;
    } else {
        echo 'Client and static facades configured; no API requests made.'.PHP_EOL;
    }
} finally {
    Wot::reset();
}
