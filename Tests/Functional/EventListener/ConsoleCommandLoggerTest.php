<?php

declare(strict_types=1);

namespace T3docs\ReferenceCoreApi\Tests\Functional\EventListener;

use PHPUnit\Framework\Attributes\Test;
use Psr\Log\LogLevel;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\ApplicationTester;
use T3docs\ReferenceCoreApi\Tests\Functional\EventListener\Fixtures\RecordingLogWriter;
use TYPO3\CMS\Core\Adapter\EventDispatcherAdapter;
use TYPO3\CMS\Core\Console\CommandRegistry;
use TYPO3\CMS\Core\Log\LogRecord;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

/**
 * Checks the listener for console events, on the page on custom commands.
 * The console application gets the event dispatcher and the commands from
 * TYPO3, as in the class CommandApplication of the Core.
 */
final class ConsoleCommandLoggerTest extends FunctionalTestCase
{
  protected array $testExtensionsToLoad = [
    'myvendor/my-extension',
  ];

  protected array $configurationToUseInTestInstance = [
    'LOG' => [
      'MyVendor' => [
        'MyExtension' => [
          'EventListener' => [
            'writerConfiguration' => [
              LogLevel::WARNING => [
                RecordingLogWriter::class => [],
              ],
            ],
          ],
        ],
      ],
    ],
  ];

  protected function setUp(): void
  {
    parent::setUp();
    RecordingLogWriter::$records = [];
  }

  #[Test]
  public function successfulCommandIsNotLogged(): void
  {
    $exitCode = $this->createApplicationTester()->run(['command' => 'myextension:dosomething']);

    self::assertSame(Command::SUCCESS, $exitCode);
    self::assertSame([], RecordingLogWriter::$records);
  }

  #[Test]
  public function exitCodeOfFailedCommandIsLogged(): void
  {
    $failingCommand = new Command('test:fail');
    $failingCommand->setCode(static fn(): int => 3);

    $this->createApplicationTester($failingCommand)->run(['command' => 'test:fail']);

    self::assertSame(
      [
        [LogLevel::WARNING, 'Command test:fail ended with exit code 3'],
      ],
      $this->getLoggedMessages(),
    );
  }

  #[Test]
  public function exceptionOfCommandIsLogged(): void
  {
    $throwingCommand = new Command('test:throw');
    $throwingCommand->setCode(static fn(): int => throw new \RuntimeException('Failed on purpose'));

    $this->createApplicationTester($throwingCommand)->run(['command' => 'test:throw']);

    self::assertSame(
      [
        [LogLevel::ERROR, 'Command test:throw failed: Failed on purpose'],
        [LogLevel::WARNING, 'Command test:throw ended with exit code 1'],
      ],
      $this->getLoggedMessages(),
    );
  }

  #[Test]
  public function exceptionOfCoreCommandIsLogged(): void
  {
    $this->createApplicationTester()->run([
      'command' => 'site:show',
      'identifier' => 'does-not-exist',
    ]);

    self::assertSame(
      [LogLevel::ERROR, 'Command site:show failed: No site found for identifier does-not-exist'],
      $this->getLoggedMessages()[0] ?? null,
    );
  }

  private function createApplicationTester(Command ...$additionalCommands): ApplicationTester
  {
    $application = new Application();
    $application->setAutoExit(false);
    $application->setDispatcher($this->get(EventDispatcherAdapter::class));
    $application->setCommandLoader($this->get(CommandRegistry::class));
    $application->addCommands($additionalCommands);

    return new ApplicationTester($application);
  }

  /**
   * @return list<array{string, string}>
   */
  private function getLoggedMessages(): array
  {
    return array_map(
      static fn(LogRecord $record): array => [
        $record->getLevel(),
        self::interpolate($record),
      ],
      RecordingLogWriter::$records,
    );
  }

  private static function interpolate(LogRecord $record): string
  {
    $replacements = [];
    foreach ($record->getData() as $key => $value) {
      $replacements['{' . $key . '}'] = (string)$value;
    }

    return strtr($record->getMessage(), $replacements);
  }
}
