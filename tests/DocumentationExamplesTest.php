<?php

declare(strict_types=1);

namespace edrard\Tests\WotClient;

use edrard\Tests\WotClient\Fixtures\RecordingExecutor;
use edrard\WgApi\Realm;
use edrard\WgAuth\AccessToken;
use edrard\WgAuth\AuthClient;
use edrard\WgAuth\Contracts\AuthTransportInterface;
use edrard\WotClient\Facades\Wot;
use edrard\WotClient\WotClient;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use RuntimeException;

final class DocumentationExamplesTest extends TestCase
{
    /** Extract only the marked, repository-owned method examples, never remote Markdown. */
    public static function examples(): iterable
    {
        $document = file_get_contents(__DIR__.'/../docs/METHODS.md');
        if ($document === false) {
            throw new RuntimeException('Method documentation is missing.');
        }
        preg_match_all('/<!-- example:([^ ]+) -->\R```php\R(.*?)\R```/s', $document, $matches, PREG_SET_ORDER);
        foreach ($matches as $match) {
            yield $match[1] => [$match[1], $match[2]];
        }
    }

    public function testDocumentationCoversTheEntireIndependentEndpointInventory(): void
    {
        $expected = array_keys(iterator_to_array(ServiceCoverageTest::endpoints()));
        $expected = [...$expected, 'auth/login', 'auth/prolongate', 'auth/logout'];
        $actual = array_keys(iterator_to_array(self::examples()));
        sort($expected);
        sort($actual);
        self::assertCount(68, $actual);
        self::assertSame($expected, $actual);
    }

    #[DataProvider('examples')]
    public function testEveryPublishedExampleExecutesWithMockTransports(string $path, string $code): void
    {
        $executor = new RecordingExecutor(static function (Realm $realm, string $path, array $parameters): array {
            $data = [];
            foreach (['account_id', 'clan_id', 'tank_id'] as $parameter) {
                if (isset($parameters[$parameter]) && is_array($parameters[$parameter])) {
                    $data = array_fill_keys($parameters[$parameter], null);
                    break;
                }
            }
            return ['status' => 'ok', 'data' => $data, 'meta' => ['page_total' => 1, 'page' => 1, 'count' => count($data)]];
        });
        $transport = new class () implements AuthTransportInterface {
            public array $paths = [];

            public function post(string $url, array $parameters): ?array
            {
                $path = trim(parse_url($url, PHP_URL_PATH), '/');
                $this->paths[] = substr($path, strlen('wot/'));
                return match ($path) {
                    'wot/auth/login' => ['location' => 'https://eu.wargaming.net/id/fixture'],
                    'wot/auth/prolongate' => ['account_id' => 1, 'access_token' => 'fixture-renewed', 'expires_at' => time() + 3600],
                    'wot/auth/logout' => null,
                    default => throw new RuntimeException('Unexpected auth example route.'),
                };
            }
        };
        $authentication = new AuthClient('fixture', $transport);
        $client = new WotClient('fixture', executor: $executor, authentication: $authentication);
        $legacyClient = new WotClient('fixture', executor: $executor, authentication: $authentication, allowDeprecated: true);
        $accountId = $clanId = $tankId = $reserveLevel = 1;
        $frontId = 'fixture-front';
        $eventId = 'fixture-event';
        $seasonId = 'fixture-season';
        $rankField = 'fixture-rank';
        $ratingType = 'fixture-rating';
        $reserveType = 'fixture-reserve';
        $callbackUri = 'https://example.test/callback';
        $token = new AccessToken(Realm::EU, $accountId, 'fixture-token', time() + 3600);
        Wot::configure(str_contains($code, '$legacyClient') ? $legacyClient : $client);
        try {
            // All dependencies are mock transports; even documented writes cannot reach WG.
            eval('use edrard\\WgApi\\Realm; use edrard\\WotClient\\Facades\\{Accounts, Tanks, Encyclopedia, Clans, ClanRatings, GlobalMap, Stronghold, Ratings, Auth}; '.$code);
        } finally {
            Wot::reset();
        }
        $paths = str_starts_with($path, 'auth/') ? $transport->paths : array_column($executor->calls, 'path');
        self::assertGreaterThanOrEqual(2, count($paths), 'Instance and static alternatives must both execute.');
        self::assertSame([$path], array_values(array_unique($paths)));
        if (str_starts_with($path, 'auth/')) {
            self::assertSame([], $executor->calls);
        } else {
            self::assertSame([], $transport->paths);
        }
    }
}
