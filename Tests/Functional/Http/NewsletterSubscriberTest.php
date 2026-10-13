<?php

declare(strict_types=1);

namespace T3docs\ReferenceCoreApi\Tests\Functional\Http;

use GuzzleHttp\Promise\FulfilledPromise;
use GuzzleHttp\Psr7\Response;
use MyVendor\MyExtension\Http\NewsletterSubscriber;
use PHPUnit\Framework\Attributes\Test;
use Psr\Http\Message\RequestInterface;
use TYPO3\CMS\Core\Http\RequestFactory;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

/**
 * Checks the POST request on the page on HTTP requests. A middleware answers
 * the request instead of sending it, so the test runs without network.
 */
final class NewsletterSubscriberTest extends FunctionalTestCase
{
  protected array $testExtensionsToLoad = [
    'myvendor/my-extension',
  ];

  #[Test]
  public function subscribeSendsTheNamesAsFormData(): void
  {
    $sentRequest = null;
    $GLOBALS['TYPO3_CONF_VARS']['HTTP']['handler']['mock'] =
      static function (callable $handler) use (&$sentRequest): callable {
        return static function (RequestInterface $request) use (&$sentRequest) {
          $sentRequest = $request;
          return new FulfilledPromise(new Response(204));
        };
      };

    $subscriber = new NewsletterSubscriber($this->get(RequestFactory::class));
    $response = $subscriber->subscribe('Jane', 'Doe');

    self::assertSame(204, $response->getStatusCode());
    self::assertInstanceOf(RequestInterface::class, $sentRequest);
    self::assertSame('POST', $sentRequest->getMethod());
    self::assertSame('https://newsletter.example.org/subscribe', (string)$sentRequest->getUri());
    self::assertSame('application/x-www-form-urlencoded', $sentRequest->getHeaderLine('Content-Type'));
    self::assertSame('first_name=Jane&last_name=Doe', (string)$sentRequest->getBody());
  }
}
