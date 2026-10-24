<?php

declare(strict_types=1);

namespace T3docs\ReferenceCoreApi\Tests\Functional\Command;

use MyVendor\MyExtension\Registry\LastRunReader;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;
use TYPO3\CMS\Core\Console\CommandRegistry;
use TYPO3\CMS\Core\Registry;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

/**
 * Checks the command that writes into the registry and the class that
 * reads the value back, both on the page on the registry.
 */
final class RecordLastRunCommandTest extends FunctionalTestCase
{
  protected array $testExtensionsToLoad = [
    'myvendor/my-extension',
  ];

  #[Test]
  public function readerFindsNothingBeforeTheFirstRun(): void
  {
    self::assertNull($this->createReader()->getLastRun());
  }

  #[Test]
  public function readerFindsTheTimesTheCommandWrote(): void
  {
    $before = time();
    $commandTester = new CommandTester(
      $this->get(CommandRegistry::class)->get('myextension:recordlastrun'),
    );

    self::assertSame(Command::SUCCESS, $commandTester->execute([]));

    $lastRun = $this->createReader()->getLastRun();
    self::assertIsArray($lastRun);
    self::assertGreaterThanOrEqual($before, $lastRun['startTime']);
    self::assertGreaterThanOrEqual($lastRun['startTime'], $lastRun['endTime']);
    self::assertLessThanOrEqual(time(), $lastRun['endTime']);
  }

  private function createReader(): LastRunReader
  {
    // No class of the extension injects the reader, so the container
    // does not keep it as a service
    return new LastRunReader($this->get(Registry::class));
  }
}
