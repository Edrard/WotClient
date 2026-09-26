<?php

declare(strict_types=1);

namespace edrard\WotClient\Facades;

use edrard\WgApi\Realm;
use edrard\WgAuth\AccessToken;
use SensitiveParameter;

/** Delegates token lifecycle to the existing WgAuth library. */
final class Auth
{
    public static function loginLocation(Realm $realm, string $redirectUri, int $tokenLifetime = 3600): string
    {
        return Wot::auth()->loginLocation($realm, $redirectUri, $tokenLifetime);
    }

    public static function prolongate(#[SensitiveParameter] AccessToken $token, int $tokenLifetime = 3600): AccessToken
    {
        return Wot::auth()->prolongate($token, $tokenLifetime);
    }

    public static function logout(#[SensitiveParameter] AccessToken $token): void
    {
        Wot::auth()->logout($token);
    }
}
