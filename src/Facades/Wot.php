<?php

declare(strict_types=1);

namespace edrard\WotClient\Facades;

use edrard\WgApi\Realm;
use edrard\WotClient\WotClient;
use LogicException;

/** Optional process-local facade. Configure explicitly; reset between independent jobs. */
final class Wot
{
    private static ?WotClient $client = null;

    public static function configure(WotClient $client): void
    {
        self::$client = $client;
    }

    public static function reset(): void
    {
        self::$client = null;
    }

    public static function setLanguage(string $language): void
    {
        self::client()->setLanguage($language);
    }

    /**
     * @param array<int|string, \edrard\WotClient\PreparedOperation> $operations
     * @return array<int|string, list<\edrard\WgGetter\FetchResult>>
     */
    public static function executeMany(#[\SensitiveParameter] array $operations): array
    {
        return self::client()->executeMany($operations);
    }

    public static function client(): WotClient
    {
        return self::$client ?? throw new LogicException('Configure the Wot facade before use.');
    }

    public static function forRealm(Realm $realm): WotClient
    {
        return self::client()->forRealm($realm);
    }

    public static function accounts(): \edrard\WotClient\Services\Accounts
    {
        return self::client()->accounts();
    }
    public static function tanks(): \edrard\WotClient\Services\Tanks
    {
        return self::client()->tanks();
    }
    public static function encyclopedia(): \edrard\WotClient\Services\Encyclopedia
    {
        return self::client()->encyclopedia();
    }
    public static function clans(): \edrard\WotClient\Services\Clans
    {
        return self::client()->clans();
    }
    public static function clanRatings(): \edrard\WotClient\Services\ClanRatings
    {
        return self::client()->clanRatings();
    }
    public static function globalMap(): \edrard\WotClient\Services\GlobalMap
    {
        return self::client()->globalMap();
    }
    public static function stronghold(): \edrard\WotClient\Services\Stronghold
    {
        return self::client()->stronghold();
    }
    public static function ratings(): \edrard\WotClient\Services\Ratings
    {
        return self::client()->ratings();
    }
}
