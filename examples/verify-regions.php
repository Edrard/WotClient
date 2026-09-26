<?php

declare(strict_types=1);

use edrard\WgApi\Realm;
use edrard\WotClient\ApiResult;
use edrard\WotClient\ClientException;
use edrard\WotClient\WotClient;

require __DIR__.'/../vendor/autoload.php';
$id = getenv('WG_APPLICATION_ID') ?: trim((string) fgets(STDIN));
if ($id === '') {
    throw new LogicException('Configure WG_APPLICATION_ID or supply it through stdin.');
}
$client = new WotClient($id);
unset($id);
$failed = false;
foreach ([Realm::EU, Realm::NA, Realm::ASIA] as $realm) {
    $regional = $client->forRealm($realm);
    $accountId = null;
    $tankId = null;
    $clanId = null;
    $checks = [
        'accounts/search' => static function () use ($regional, &$accountId): ApiResult {
            $result = $regional->accounts()->search('Player', fields: ['account_id'], limit: 1);
            foreach ($result->records() as $record) {
                $accountId = $record?->integer('account_id');
            }
            return $result;
        },
        'accounts/info' => static function () use ($regional, &$accountId, &$tankId, &$clanId): ApiResult {
            return $regional->accounts()->info([$accountId ?? 500000001], fields: ['account_id', 'nickname', 'statistics.all.battles', 'statistics.all.wins']);
        },
        'accounts/tanks' => static function () use ($regional, &$accountId, &$tankId, &$clanId): ApiResult {
            return $regional->accounts()->tanks([$accountId ?? 500000001], fields: ['tank_id', 'statistics.wins']);
        },
        'accounts/achievements' => static function () use ($regional, &$accountId, &$tankId, &$clanId): ApiResult {
            return $regional->accounts()->achievements([$accountId ?? 500000001], fields: ['achievements']);
        },
        'accounts/wtr' => static function () use ($regional, &$accountId, &$tankId, &$clanId): ApiResult {
            return $regional->accounts()->wtr([$accountId ?? 500000001], fields: ['account_id', 'rating']);
        },
        'encyclopedia/allVehicles' => static function () use ($regional, &$tankId): ApiResult {
            $result = $regional->encyclopedia()->allVehicles(fields: ['tank_id', 'name', 'tier', 'is_premium', 'default_profile.hp'], limit: 100, maxPages: 100);
            $tankId = array_key_first($result->data() ?? []);
            return $result;
        },
        'encyclopedia/info' => static function () use ($regional, &$accountId, &$tankId, &$clanId): ApiResult {
            return $regional->encyclopedia()->info(fields: ['game_version']);
        },
        'encyclopedia/vehicleProfile' => static function () use ($regional, &$accountId, &$tankId, &$clanId): ApiResult {
            return $regional->encyclopedia()->vehicleProfile((int) ($tankId ?? 1), fields: ['hp']);
        },
        'tanks/stats' => static function () use ($regional, &$accountId, &$tankId, &$clanId): ApiResult {
            return $regional->tanks()->stats($accountId ?? 500000001, fields: ['tank_id']);
        },
        'tanks/achievements' => static function () use ($regional, &$accountId, &$tankId, &$clanId): ApiResult {
            return $regional->tanks()->achievements($accountId ?? 500000001, fields: ['tank_id']);
        },
        'clans/search' => static function () use ($regional, &$clanId): ApiResult {
            $result = $regional->clans()->search(fields: ['clan_id'], limit: 1);
            foreach ($result->records() as $record) {
                $clanId = $record?->integer('clan_id');
            }
            return $result;
        },
        'clans/info' => static function () use ($regional, &$accountId, &$tankId, &$clanId): ApiResult {
            return $regional->clans()->info([$clanId ?? 1], fields: ['clan_id', 'name']);
        },
        'clans/memberHistory' => static function () use ($regional, &$accountId, &$tankId, &$clanId): ApiResult {
            return $regional->clans()->memberHistory($accountId ?? 500000001, fields: ['account_id', 'clan_id']);
        },
        'clanRatings/dates' => static function () use ($regional, &$accountId, &$tankId, &$clanId): ApiResult {
            return $regional->clanRatings()->dates(limit: 1);
        },
        'globalMap/fronts' => static function () use ($regional, &$accountId, &$tankId, &$clanId): ApiResult {
            return $regional->globalMap()->fronts(fields: ['front_id'], limit: 1);
        },
        'globalMap/info' => static function () use ($regional, &$accountId, &$tankId, &$clanId): ApiResult {
            return $regional->globalMap()->info(fields: ['state']);
        },
        'stronghold/clanInfo' => static function () use ($regional, &$accountId, &$tankId, &$clanId): ApiResult {
            return $regional->stronghold()->clanInfo([$clanId ?? 1], fields: ['clan_id']);
        },
    ];
    foreach ($checks as $name => $check) {
        try {
            $result = $check();
            echo json_encode(['realm' => $realm->value, 'method' => $name, 'status' => 'ok', 'entries' => count($result)], JSON_THROW_ON_ERROR).PHP_EOL;
        } catch (ClientException $exception) {
            $failed = true;
            echo json_encode(['realm' => $realm->value, 'method' => $name, 'status' => 'failed', 'code' => $exception->providerCode, 'error' => $exception->getMessage()], JSON_THROW_ON_ERROR).PHP_EOL;
        }
    }
}
exit($failed ? 1 : 0);
