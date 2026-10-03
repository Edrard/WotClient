<?php

declare(strict_types=1);

namespace edrard\Tests\WotClient;

use edrard\WgApi\Realm;
use edrard\WgGetter\Contracts\DataGetterInterface;
use edrard\WgGetter\Contracts\BatchTransportInterface;
use edrard\WgGetter\FetchResult;
use edrard\WgGetter\Http\HttpResult;
use edrard\WgGetter\Http\GuzzleTransport;
use edrard\WgGetter\WgDataGetter;
use edrard\WotClient\Facades\Accounts;
use edrard\WotClient\Facades\Wot;
use edrard\WotClient\WotClient;
use edrard\WotClient\PreparedOperation;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;

final class ClientContractTest extends TestCase
{
    public function testRecordingGetterPreservesAtomicQueueAndConsumption(): void
    {
        $getter = new RecordingGetter();
        $getter->setUrls(['first' => 'https://example.test/first']);
        $getter->setUrls(['second' => 'https://example.test/second']);
        try {
            $getter->setUrls(['third' => 'https://example.test/third', 'first' => 'https://example.test/duplicate']);
            self::fail('Duplicate keys must be rejected.');
        } catch (InvalidArgumentException) {
            self::assertSame(['first', 'second'], array_keys($getter->getData()));
        }
        self::assertSame([], $getter->getData());
        self::assertCount(1, $getter->waves);
        $getter->setUrls(['discarded' => 'https://example.test/discarded']);
        $getter->cleanUrls();
        self::assertSame([], $getter->getData());
        self::assertCount(1, $getter->waves);
    }

    public function testNOverKBecomesOneGetterMultirequestWithoutAClientLimit(): void
    {
        $getter = new RecordingGetter();
        $client = new WotClient('app-id', getter: $getter);
        $ids = range(500000001, 500000275);

        $results = $client->accounts()->info($ids, 25, extra: ['statistics.random'], fields: ['account_id']);

        self::assertCount(11, $results);
        self::assertCount(1, $getter->waves);
        self::assertCount(11, $getter->waves[0]);
        foreach ($getter->waves[0] as $url) {
            parse_str((string) parse_url($url, PHP_URL_QUERY), $query);
            self::assertCount(25, explode(',', $query['account_id']));
            self::assertSame('statistics.random', $query['extra']);
            self::assertSame('account_id', $query['fields']);
        }
        self::assertSame('{"status":"error","error":{"message":"untouched"}}', $results[0]->body);
    }

    public function testMixedMethodsAndRealmsReturnOriginalGetterResultsByOperation(): void
    {
        $getter = new RecordingGetter();
        $eu = new WotClient('app-id', getter: $getter);
        $asia = $eu->forRealm(Realm::ASIA);

        $results = $eu->executeMany([
            'info' => $eu->accounts()->prepareInfo([500000001], 1),
            'tanks' => $asia->accounts()->prepareTanks([2000000001], 1),
            'achievements' => $eu->accounts()->prepareAchievements([500000001], 1),
        ]);

        self::assertSame(['info', 'tanks', 'achievements'], array_keys($results));
        self::assertCount(1, $getter->waves);
        self::assertCount(3, $getter->waves[0]);
        self::assertCount(1, $results['info']);
        self::assertCount(1, $results['tanks']);
        self::assertCount(1, $results['achievements']);
        self::assertStringContainsString('api.worldoftanks.asia', $getter->waves[0][1]);
    }

    public function testExactNicknamesUseCallerSuppliedKInOneMultirequest(): void
    {
        $getter = new RecordingGetter();
        $client = new WotClient('app-id', getter: $getter);

        $results = $client->accounts()->searchExactMany(['Alpha', 'Bravo', 'Charlie'], 2);

        self::assertCount(2, $results);
        self::assertCount(1, $getter->waves);
        parse_str((string) parse_url($getter->waves[0][0], PHP_URL_QUERY), $first);
        parse_str((string) parse_url($getter->waves[0][1], PHP_URL_QUERY), $second);
        self::assertSame('Alpha,Bravo', $first['search']);
        self::assertSame('Charlie', $second['search']);
        self::assertSame('exact', $first['type']);
    }

    public function testNicknameBatchesRejectConflictingTypesBeforeHttp(): void
    {
        $getter = new RecordingGetter();
        $client = new WotClient('app-id', getter: $getter);

        foreach (['startswith', 'invalid', '', 0, false, []] as $type) {
            try {
                $client->request('account/list', ['search' => ['Edr', 'Jov'], 'type' => $type], 2);
                self::fail('A conflicting search type must not be replaced with exact.');
            } catch (InvalidArgumentException $exception) {
                self::assertStringContainsString('type=exact', $exception->getMessage());
            }
        }
        self::assertSame([], $getter->waves);
    }

    public function testDirectlyConstructedNicknameOperationCannotOverrideSearchType(): void
    {
        $getter = new RecordingGetter();
        $client = new WotClient('app-id', getter: $getter);
        $operation = new PreparedOperation(Realm::EU, 'account/list', ['search' => ['Edr', 'Jov'], 'type' => 'startswith'], 2);

        try {
            $client->executeMany(['prefixes' => $operation]);
            self::fail('Manually constructed operations must obey the same search contract.');
        } catch (InvalidArgumentException $exception) {
            self::assertStringContainsString('type=exact', $exception->getMessage());
        }
        self::assertSame([], $getter->waves);
    }

    public function testGenericNicknameBatchesKeepExactDefaultAndExplicitExact(): void
    {
        $getter = new RecordingGetter();
        $client = new WotClient('app-id', getter: $getter);

        foreach ([[], ['type' => null], ['type' => 'exact']] as $parameters) {
            $results = $client->request('account/list', ['search' => ['Alpha', 'Bravo', 'Charlie']] + $parameters, 2);
            self::assertCount(2, $results);
        }
        self::assertCount(3, $getter->waves);
        foreach ($getter->waves as $wave) {
            parse_str((string) parse_url($wave[0], PHP_URL_QUERY), $first);
            parse_str((string) parse_url($wave[1], PHP_URL_QUERY), $second);
            self::assertSame('Alpha,Bravo', $first['search']);
            self::assertSame('Charlie', $second['search']);
            self::assertSame('exact', $first['type']);
            self::assertSame('exact', $second['type']);
        }
    }

    public function testSeparatePrefixSearchesExecuteTogetherWithoutChangingType(): void
    {
        $getter = new RecordingGetter();
        $client = new WotClient('app-id', getter: $getter);
        $results = $client->executeMany([
            'edr' => $client->accounts()->prepareSearch('Edr', type: 'startswith'),
            'jov' => $client->accounts()->prepareSearch('Jov', type: 'startswith'),
        ]);

        self::assertSame(['edr', 'jov'], array_keys($results));
        self::assertCount(1, $getter->waves);
        self::assertCount(2, $getter->waves[0]);
        foreach (['Edr', 'Jov'] as $index => $prefix) {
            parse_str((string) parse_url($getter->waves[0][$index], PHP_URL_QUERY), $query);
            self::assertSame($prefix, $query['search']);
            self::assertSame('startswith', $query['type']);
        }
    }

    public function testCallerIdentifiersAreNotSilentlyDeduplicated(): void
    {
        $getter = new RecordingGetter();
        $client = new WotClient('app-id', getter: $getter);
        $client->accounts()->info([500000001, 500000001, 500000002], 2);

        parse_str((string) parse_url($getter->waves[0][0], PHP_URL_QUERY), $first);
        parse_str((string) parse_url($getter->waves[0][1], PHP_URL_QUERY), $second);
        self::assertSame('500000001,500000001', $first['account_id']);
        self::assertSame('500000002', $second['account_id']);
    }

    public function testFailureAndInvalidJsonPassThroughWithoutAggregation(): void
    {
        $getter = new RecordingGetter();
        $first = new FetchResult(new HttpResult(200, 'this is not JSON'), 1);
        $second = new FetchResult(new HttpResult(0, transportFailure: true), 3);
        $getter->scripted = [0 => $first, 1 => $second];
        $client = new WotClient('app-id', getter: $getter);

        $results = $client->accounts()->info([500000001, 500000002], 1);

        self::assertSame($first, $results[0]);
        self::assertSame($second, $results[1]);
        self::assertSame('this is not JSON', $results[0]->body);
        self::assertNull($results[1]->body);
    }

    public function testPrivateGetTokenIsForwardedOverHttpsAndNotShownInClientDebug(): void
    {
        $getter = new RecordingGetter();
        $client = new WotClient('private-application-id', getter: $getter);
        $client->accounts()->info([500000001], 1, accessToken: 'private-access-token');
        parse_str((string) parse_url($getter->waves[0][0], PHP_URL_QUERY), $query);
        ob_start();
        var_dump($client);
        $debug = (string) ob_get_clean();

        self::assertSame('private-access-token', $query['access_token']);
        self::assertSame('https', parse_url($getter->waves[0][0], PHP_URL_SCHEME));
        self::assertStringNotContainsString('private-application-id', $debug);
        self::assertStringNotContainsString('private-access-token', $debug);
    }

    public function testStaticMethodsUseTheSameClient(): void
    {
        $getter = new RecordingGetter();
        Wot::configure(new WotClient('app-id', getter: $getter));
        try {
            Wot::setLanguage('fr');
            $results = Accounts::info([500000001], 1);
            self::assertCount(1, $results);
            self::assertCount(1, $getter->waves);
            parse_str((string) parse_url($getter->waves[0][0], PHP_URL_QUERY), $query);
            self::assertSame('fr', $query['language']);
        } finally {
            Wot::reset();
        }
    }

    public function testRequestLanguageOverridesTheMutableClientDefaultForOnlyThatRequest(): void
    {
        $getter = new RecordingGetter();
        $client = new WotClient('app-id', language: 'de', getter: $getter);
        $encyclopedia = $client->encyclopedia();

        $encyclopedia->info();
        $encyclopedia->info(language: 'fr');
        $encyclopedia->info();
        $client->setLanguage('en');
        $encyclopedia->info();
        $encyclopedia->info(language: null);

        self::assertCount(5, $getter->waves);
        foreach (['de', 'fr', 'de', 'en', 'en'] as $index => $language) {
            parse_str((string) parse_url($getter->waves[$index][0], PHP_URL_QUERY), $query);
            self::assertSame($language, $query['language']);
        }
    }

    public function testPreparedLanguagesSurviveDefaultChangesAndExecutionByAnotherClient(): void
    {
        $getter = new RecordingGetter();
        $source = new WotClient('app-id', language: 'de', getter: $getter);
        $operations = [
            'default' => $source->accounts()->prepareInfo([1], 1),
            'override' => $source->encyclopedia()->prepareInfo(language: 'fr'),
            'names' => $source->accounts()->prepareSearchExactMany(['Alpha', 'Bravo'], 1),
        ];
        $source->setLanguage('pl');
        $operations['new-default'] = $source->encyclopedia()->prepareInfo();
        $executor = new WotClient('app-id', language: 'en', getter: $getter);

        $results = $executor->executeMany($operations);

        self::assertSame('de', $operations['default']->parameters()['language']);
        self::assertSame('fr', $operations['override']->parameters()['language']);
        self::assertSame('pl', $operations['new-default']->parameters()['language']);
        self::assertCount(1, $getter->waves);
        self::assertCount(2, $results['names']);
        foreach (['de', 'fr', 'de', 'de', 'pl'] as $index => $language) {
            parse_str((string) parse_url($getter->waves[0][$index], PHP_URL_QUERY), $query);
            self::assertSame($language, $query['language']);
        }
    }

    public function testLanguageDefaultsStayLocalToRealmClonesAndSkipUnsupportedMethods(): void
    {
        $getter = new RecordingGetter();
        $eu = new WotClient('app-id', language: 'de', getter: $getter);
        $asia = $eu->forRealm(Realm::ASIA);
        $eu->setLanguage('fr');

        $results = $eu->executeMany([
            'eu' => $eu->encyclopedia()->prepareInfo(),
            'asia' => $asia->encyclopedia()->prepareInfo(),
            'types' => $eu->clanRatings()->prepareTypes(),
        ]);

        self::assertCount(3, $results);
        parse_str((string) parse_url($getter->waves[0][0], PHP_URL_QUERY), $euQuery);
        parse_str((string) parse_url($getter->waves[0][1], PHP_URL_QUERY), $asiaQuery);
        parse_str((string) parse_url($getter->waves[0][2], PHP_URL_QUERY), $typesQuery);
        self::assertSame('fr', $euQuery['language']);
        self::assertSame('de', $asiaQuery['language']);
        self::assertArrayNotHasKey('language', $typesQuery);
    }

    public function testPostMethodCannotEnterGetPipeline(): void
    {
        $client = new WotClient('app-id', getter: new RecordingGetter());
        $this->expectException(InvalidArgumentException::class);
        $client->request('stronghold/activateclanreserve');
    }

    public function testDeprecatedMethodsExecuteTogetherWithoutOptInAndPreserveRawErrors(): void
    {
        $getter = new RecordingGetter();
        $client = new WotClient('app-id', getter: $getter);
        $operations = [
            'encyclopedia/tanks' => $client->encyclopedia()->prepareTanks(),
            'encyclopedia/tankinfo' => $client->encyclopedia()->prepareTankInfo([1], batchSize: 1),
            'encyclopedia/tankengines' => $client->encyclopedia()->prepareTankEngines(),
            'encyclopedia/tankturrets' => $client->encyclopedia()->prepareTankTurrets(),
            'encyclopedia/tankradios' => $client->encyclopedia()->prepareTankRadios(),
            'encyclopedia/tankchassis' => $client->encyclopedia()->prepareTankChassis(),
            'encyclopedia/tankguns' => $client->encyclopedia()->prepareTankGuns(),
            'ratings/types' => $client->ratings()->prepareTypes(),
            'ratings/dates' => $client->ratings()->prepareDates('all'),
            'ratings/accounts' => $client->ratings()->prepareAccounts('all', [1], batchSize: 1),
            'ratings/neighbors' => $client->ratings()->prepareNeighbors('all', 1, 'battles_count'),
            'ratings/top' => $client->ratings()->prepareTop('all', 'battles_count'),
        ];

        $results = $client->executeMany($operations);

        self::assertCount(1, $getter->waves);
        self::assertCount(12, $getter->waves[0]);
        self::assertSame(array_keys($operations), array_keys($results));
        foreach (array_keys($operations) as $index => $path) {
            self::assertSame('/wot/'.$path.'/', parse_url($getter->waves[0][$index], PHP_URL_PATH));
            self::assertCount(1, $results[$path]);
            self::assertSame('{"status":"error","error":{"message":"untouched"}}', $results[$path][0]->body);
        }
    }

    public function testRealUrlBuilderGetterAndHttpTransportWorkTogether(): void
    {
        $history = [];
        $stack = HandlerStack::create(new MockHandler([
            new Response(200, [], '{"status":"error","error":{"message":"kept"}}'),
            new Response(504, [], 'temporary gateway failure'),
            new Response(200, [], '{"status":"ok","data":null}'),
            new Response(200, [], '{"status":"ok","data":{"recovered":true}}'),
        ]));
        $stack->push(Middleware::history($history));
        $getter = new WgDataGetter(new GuzzleTransport(new Client(['handler' => $stack])), sleep: static function (): void {
        });
        $client = new WotClient('app-id', getter: $getter);

        $results = $client->executeMany([
            'info' => $client->accounts()->prepareInfo([500000001], 1),
            'tanks' => $client->accounts()->prepareTanks([500000001], 1),
            'achievements' => $client->accounts()->prepareAchievements([500000001], 1),
        ]);

        self::assertCount(4, $history);
        self::assertSame('{"status":"error","error":{"message":"kept"}}', $results['info'][0]->body);
        self::assertSame(1, $results['info'][0]->attempts);
        self::assertSame(2, $results['tanks'][0]->attempts);
        self::assertSame('{"status":"ok","data":{"recovered":true}}', $results['tanks'][0]->body);
        self::assertSame(1, $results['achievements'][0]->attempts);
        self::assertStringContainsString('/wot/account/tanks/', (string) $history[3]['request']->getUri());
    }
}

/** @internal */
final class RecordingGetter implements DataGetterInterface
{
    /** @var list<array<int|string, string>> */
    public array $waves = [];
    /** @var array<int|string, FetchResult> */
    public array $scripted = [];
    private WgDataGetter $getter;

    public function __construct()
    {
        $transport = new class ($this) implements BatchTransportInterface {
            public function __construct(private RecordingGetter $owner)
            {
            }

            public function send(array $urls): array
            {
                $this->owner->waves[] = $urls;
                $results = [];
                foreach ($urls as $key => $_) {
                    $result = $this->owner->scripted[$key] ?? null;
                    $results[$key] = $result === null
                        ? new HttpResult(200, '{"status":"error","error":{"message":"untouched"}}')
                        : new HttpResult($result->httpStatus ?? 0, $result->body ?? '', $result->retryAfter, $result->transportFailure);
                }
                return $results;
            }
        };
        // Reuse the real queue rather than maintaining a different test implementation.
        $this->getter = new WgDataGetter($transport, retry: new \edrard\WgGetter\RetryPolicy(maxAttempts: 1));
    }

    public function setUrls(array $urls): void
    {
        $this->getter->setUrls($urls);
    }

    public function cleanUrls(): void
    {
        $this->getter->cleanUrls();
    }

    public function getData(): array
    {
        $results = $this->getter->getData();
        foreach ($results as $key => $result) {
            $results[$key] = $this->scripted[$key] ?? $result;
        }
        return $results;
    }
}
