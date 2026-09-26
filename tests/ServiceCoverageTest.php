<?php

declare(strict_types=1);

namespace edrard\Tests\WotClient;

use edrard\Tests\WotClient\Fixtures\RecordingExecutor;
use edrard\WgApi\Realm;
use edrard\WgAuth\AccessToken;
use edrard\WotClient\Facades\Wot;
use edrard\WotClient\WotClient;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use ReflectionMethod;

final class ServiceCoverageTest extends TestCase
{
    /** Independent public routing inventory; required arguments are supplied through PHP reflection. */
    public static function endpoints(): iterable
    {
        $groups = [
            'Accounts' => ['accounts', 'account', ['list' => 'search', 'info' => 'info', 'tanks' => 'tanks', 'achievements' => 'achievements', 'wtr' => 'wtr']],
            'Tanks' => ['tanks', 'tanks', ['stats' => 'stats', 'achievements' => 'achievements', 'mastery' => 'mastery']],
            'Clans' => ['clans', 'clans', ['list' => 'search', 'info' => 'info', 'accountinfo' => 'accountInfo', 'glossary' => 'glossary', 'messageboard' => 'messageboard', 'memberhistory' => 'memberHistory']],
            'ClanRatings' => ['clanRatings', 'clanratings', ['types' => 'types', 'dates' => 'dates', 'clans' => 'clans', 'neighbors' => 'neighbors', 'top' => 'top']],
            'Ratings' => ['ratings', 'ratings', ['types' => 'types', 'dates' => 'dates', 'accounts' => 'accounts', 'neighbors' => 'neighbors', 'top' => 'top']],
            'Stronghold' => ['stronghold', 'stronghold', ['claninfo' => 'clanInfo', 'clanreserves' => 'clanReserves', 'activateclanreserve' => 'activateClanReserve']],
            'GlobalMap' => ['globalMap', 'globalmap', [
                'fronts' => 'fronts', 'provinces' => 'provinces', 'claninfo' => 'clanInfo', 'clanprovinces' => 'clanProvinces', 'clanbattles' => 'clanBattles',
                'seasons' => 'seasons', 'seasonclaninfo' => 'seasonClanInfo', 'seasonaccountinfo' => 'seasonAccountInfo', 'seasonrating' => 'seasonRating', 'seasonratingneighbors' => 'seasonRatingNeighbors',
                'events' => 'events', 'eventclaninfo' => 'eventClanInfo', 'eventaccountinfo' => 'eventAccountInfo', 'eventaccountratings' => 'eventAccountRatings',
                'eventaccountratingneighbors' => 'eventAccountRatingNeighbors', 'eventrating' => 'eventRating', 'eventratingneighbors' => 'eventRatingNeighbors', 'info' => 'info',
            ]],
            'Encyclopedia' => ['encyclopedia', 'encyclopedia', [
                'tanks' => 'tanks', 'tankinfo' => 'tankInfo', 'vehicles' => 'vehicles', 'vehicleprofile' => 'vehicleProfile',
                'tankengines' => 'tankEngines', 'tankturrets' => 'tankTurrets', 'tankradios' => 'tankRadios', 'tankchassis' => 'tankChassis', 'tankguns' => 'tankGuns',
                'achievements' => 'achievements', 'info' => 'info', 'arenas' => 'arenas', 'provisions' => 'provisions', 'personalmissions' => 'personalMissions',
                'boosters' => 'boosters', 'vehicleprofiles' => 'vehicleProfiles', 'modules' => 'modules', 'badges' => 'badges', 'crewroles' => 'crewRoles', 'crewskills' => 'crewSkills',
            ]],
        ];
        foreach ($groups as $class => [$accessor, $section, $methods]) {
            foreach ($methods as $slug => $method) {
                yield $section.'/'.$slug => [$class, $accessor, $method, $section.'/'.$slug];
            }
        }
    }

    #[DataProvider('endpoints')]
    public function testServicesAndStaticFacadesRouteEveryDataEndpoint(string $class, string $accessor, string $method, string $path): void
    {
        $executor = new RecordingExecutor(static function (Realm $realm, string $path, array $parameters): array {
            $data = [];
            foreach (['account_id', 'clan_id', 'tank_id'] as $parameter) {
                if (isset($parameters[$parameter]) && is_array($parameters[$parameter])) {
                    $data = array_fill_keys($parameters[$parameter], null);
                    break;
                }
            }
            return ['status' => 'ok', 'data' => $data];
        });
        $client = new WotClient('fixture', executor: $executor, allowDeprecated: true);
        $service = $client->$accessor();
        $reflection = new ReflectionMethod($service, $method);
        $arguments = [];
        foreach ($reflection->getParameters() as $parameter) {
            if ($parameter->isOptional()) {
                break;
            }
            $arguments[] = match ($parameter->getName()) {
                'accessToken' => new AccessToken(Realm::EU, 1, 'fixture-token', time() + 3600),
                'vehicleLevel' => (string) $parameter->getType() === 'array' ? ['6'] : '6',
                'frontIds' => ['fixture-front'],
                'distribution' => 'xp',
                'percentile' => [10],
                default => match ((string) $parameter->getType()) {
                    'array' => [1], 'int' => 1, default => 'Fixture',
                },
            };
        }
        $instanceResult = $service->$method(...$arguments);
        Wot::configure($client);
        try {
            $facadeClass = 'edrard\\WotClient\\Facades\\'.$class;
            $staticResult = $facadeClass::$method(...$arguments);
        } finally {
            Wot::reset();
        }
        self::assertSame($instanceResult->data(), $staticResult->data());
        self::assertSame($path, $executor->calls[0]['path']);
        self::assertSame($path, $executor->calls[1]['path']);
        self::assertSame($path === 'stronghold/activateclanreserve', $executor->calls[0]['write']);
        self::assertArrayNotHasKey('access_token', $executor->calls[0]['parameters']);
    }
}
