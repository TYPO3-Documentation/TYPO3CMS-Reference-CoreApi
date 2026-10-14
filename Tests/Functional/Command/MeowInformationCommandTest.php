<?php

declare(strict_types=1);

namespace T3docs\ReferenceCoreApi\Tests\Functional\Command;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use Psr\Http\Message\RequestInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;
use TYPO3\CMS\Core\Console\CommandRegistry;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

/**
 * Checks the command with injected services on the page on custom commands,
 * and the requester it uses from the page on HTTP requests. The cat fact API
 * is answered by a Guzzle mock handler, so the test runs without network.
 */
final class MeowInformationCommandTest extends FunctionalTestCase
{
  protected array $testExtensionsToLoad = [
    'myvendor/my-extension',
  ];

  private ?RequestInterface $sentRequest = null;

  #[Test]
  public function commandPrintsTheFactFromTheApi(): void
  {
    $this->answerApiWith(new Response(
      200,
      ['Content-Type' => 'application/json'],
      '{"fact":"Cats sleep for most of the day.","length":31}',
    ));

    $commandTester = $this->createCommandTester();

    self::assertSame(Command::SUCCESS, $commandTester->execute([]));
    self::assertSame('Cats sleep for most of the day.', trim($commandTester->getDisplay()));
    self::assertSame('https://catfact.ninja/fact', (string)$this->sentRequest?->getUri());
    self::assertSame('no-cache', $this->sentRequest?->getHeaderLine('Cache-Control'));
  }

  #[Test]
  public function commandFailsWhenTheApiDoesNotReturnJson(): void
  {
    $this->answerApiWith(new Response(200, ['Content-Type' => 'text/html'], '<p>Meow</p>'));

    $commandTester = $this->createCommandTester();

    self::assertSame(Command::FAILURE, $commandTester->execute([]));
    self::assertSame('', $commandTester->getDisplay());
  }

  #[Test]
  public function commandFailsWhenTheApiReturnsAnError(): void
  {
    $this->answerApiWith(new Response(503));

    self::assertSame(Command::FAILURE, $this->createCommandTester()->execute([]));
  }

  private function answerApiWith(Response $response): void
  {
    $mockHandler = new MockHandler([$response]);
    // A middleware that answers the request instead of sending it
    $GLOBALS['TYPO3_CONF_VARS']['HTTP']['handler']['mock'] =
      fn(callable $handler): callable => function (RequestInterface $request, array $options) use ($mockHandler) {
        $this->sentRequest = $request;
        return $mockHandler($request, $options);
      };
  }

  private function createCommandTester(): CommandTester
  {
    return new CommandTester(
      $this->get(CommandRegistry::class)->get('myextension:meowinformation'),
    );
  }
}
