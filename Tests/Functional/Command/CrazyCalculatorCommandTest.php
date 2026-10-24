<?php

declare(strict_types=1);

namespace T3docs\ReferenceCoreApi\Tests\Functional\Command;

use PHPUnit\Framework\Attributes\Test;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;
use TYPO3\CMS\Core\Console\CommandRegistry;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

/**
 * Checks the interactive command from the page on custom commands.
 */
final class CrazyCalculatorCommandTest extends FunctionalTestCase
{
  protected array $testExtensionsToLoad = [
    'myvendor/my-extension',
  ];

  #[Test]
  public function commandSquaresTheNumber(): void
  {
    $commandTester = $this->createCommandTester();
    $commandTester->setInputs(['5', 'squared']);

    self::assertSame(Command::SUCCESS, $commandTester->execute([]));
    self::assertStringContainsString('5 squared is 25', $commandTester->getDisplay());
  }

  #[Test]
  public function commandAsksAgainUntilTheNumberIsGreaterThanZero(): void
  {
    $commandTester = $this->createCommandTester();
    $commandTester->setInputs(['0', '-3', '3', 'squared']);

    self::assertSame(Command::SUCCESS, $commandTester->execute([]));
    self::assertStringContainsString('3 squared is 9', $commandTester->getDisplay());
  }

  #[Test]
  public function commandUsesTheDefaultsWhenTheUserOnlyPressesEnter(): void
  {
    $commandTester = $this->createCommandTester();
    $commandTester->setInputs(['', '']);

    self::assertSame(Command::SUCCESS, $commandTester->execute([]));
    self::assertStringContainsString('42 squared is 1764', $commandTester->getDisplay());
  }

  #[Test]
  public function commandFailsForAnUnsupportedOperation(): void
  {
    $commandTester = $this->createCommandTester();
    $commandTester->setInputs(['5', 'divided by 0']);

    self::assertSame(Command::FAILURE, $commandTester->execute([]));
    self::assertStringContainsString('is not supported', $commandTester->getDisplay());
  }

  private function createCommandTester(): CommandTester
  {
    return new CommandTester($this->get(CommandRegistry::class)->get('myextension:crazycalculator'));
  }
}
