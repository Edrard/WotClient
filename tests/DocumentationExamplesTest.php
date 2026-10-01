<?php

declare(strict_types=1);

namespace edrard\Tests\WotClient;

use edrard\WgGetter\Contracts\BatchTransportInterface;
use edrard\WgGetter\FetchResult;
use edrard\WgGetter\Http\HttpResult;
use edrard\WgGetter\WgDataGetter;
use edrard\WotClient\Facades\Wot;
use edrard\WotClient\WotClient;
use PHPUnit\Framework\TestCase;

final class DocumentationExamplesTest extends TestCase
{
    public function testReadmePhpExamplesHaveValidSyntax(): void
    {
        foreach (['WgApi', 'WgDataGetter', 'WotClient'] as $package) {
            $markdown = file_get_contents(__DIR__.'/../../'.$package.'/README.md');
            self::assertIsString($markdown);
            preg_match_all('/```php\R(.*?)```/s', $markdown, $matches);
            self::assertNotEmpty($matches[1], $package);
            foreach ($matches[1] as $snippet) {
                self::assertNotEmpty(token_get_all("<?php\n".$snippet, TOKEN_PARSE), $package);
            }
        }
    }

    public function testEveryDocumentedCallAcceptsItsArgumentsAndReturnsRawResults(): void
    {
        $getter = new WgDataGetter(new class () implements BatchTransportInterface {
            public function send(array $urls): array
            {
                $results = [];
                foreach ($urls as $key => $_) {
                    $results[$key] = new HttpResult(200, '{"status":"ok","data":null}');
                }
                return $results;
            }
        });
        $client = new WotClient('documentation-example', getter: $getter);
        $markdown = file_get_contents(__DIR__.'/../docs/METHODS.md');
        self::assertIsString($markdown);
        preg_match_all('/^(Instance|Static): `([^`]+)`$/m', $markdown, $matches, PREG_SET_ORDER);
        self::assertCount(130, $matches);
        Wot::configure($client);
        try {
            foreach ($matches as $match) {
                $expression = $match[2];
                if ($match[1] === 'Static') {
                    $expression = '\\edrard\\WotClient\\Facades\\'.$expression;
                }
                // Evaluate only the trusted, repository-generated documentation call.
                $results = eval('return '.$expression.';');
                self::assertIsArray($results, $match[2]);
                self::assertNotEmpty($results, $match[2]);
                foreach ($results as $result) {
                    self::assertInstanceOf(FetchResult::class, $result);
                    self::assertSame('{"status":"ok","data":null}', $result->body);
                }
            }
        } finally {
            Wot::reset();
        }
    }
}
