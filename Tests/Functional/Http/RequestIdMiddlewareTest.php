<?php

declare(strict_types=1);

namespace T3docs\ReferenceCoreApi\Tests\Functional\Http;

use GuzzleHttp\Promise\FulfilledPromise;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use Psr\Http\Message\RequestInterface;
use TYPO3\CMS\Core\Http\RequestFactory;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

/**
 * Loads the configuration snippet from the section on custom middleware
 * handlers and checks that the middleware it adds runs on every request.
 */
final class RequestIdMiddlewareTest extends FunctionalTestCase
{
  protected array $testExtensionsToLoad = [
    'myvendor/my-extension',
  ];

  #[Test]
  public function configuredMiddlewareAddsARequestId(): void
  {
    require dirname(__DIR__, 3)
      . '/Documentation/ExtensionArchitecture/HowTo/RestRequests/_additional.php';

    $sentRequests = [];
    // Added after the snippet, so it runs last and sees the final request
    $GLOBALS['TYPO3_CONF_VARS']['HTTP']['handler']['mock'] =
      static function (callable $handler) use (&$sentRequests): callable {
        return static function (RequestInterface $request) use (&$sentRequests) {
          $sentRequests[] = $request;
          return new FulfilledPromise(new Response(200));
        };
      };

    $requestFactory = $this->get(RequestFactory::class);
    $requestFactory->request('https://example.org/first');
    $requestFactory->request('https://example.org/second');

    self::assertCount(2, $sentRequests);
    $firstId = $sentRequests[0]->getHeaderLine('X-Request-Id');
    self::assertMatchesRegularExpression('/^[0-9a-f]{16}$/', $firstId);
    self::assertNotSame($firstId, $sentRequests[1]->getHeaderLine('X-Request-Id'));
  }
}
