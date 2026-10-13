<?php

declare(strict_types=1);

namespace T3docs\ReferenceCoreApi\Tests\Functional\Command;

use PHPUnit\Framework\Attributes\Test;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;
use TYPO3\CMS\Core\Console\CommandRegistry;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

/**
 * Checks the command with an argument and an option from the console command
 * tutorial and the page on custom commands.
 */
final class CreateWizardCommandTest extends FunctionalTestCase
{
  protected array $testExtensionsToLoad = [
    'myvendor/my-extension',
  ];

  #[Test]
  public function commandCannotBeScheduled(): void
  {
    $commandRegistry = $this->get(CommandRegistry::class);
    self::assertTrue($commandRegistry->has('myextension:createwizard'));
    self::assertArrayNotHasKey(
      'myextension:createwizard',
      $commandRegistry->getSchedulableCommandsConfiguration(),
    );
  }

  #[Test]
  public function commandAcceptsTheArgumentAndTheShortOption(): void
  {
    $command = $this->get(CommandRegistry::class)->get('myextension:createwizard');
    $commandTester = new CommandTester($command);

    self::assertSame(Command::SUCCESS, $commandTester->execute(['wizardName' => 'Merlin', '-b' => true]));
    self::assertSame('Merlin', $commandTester->getInput()->getArgument('wizardName'));
    self::assertTrue($commandTester->getInput()->getOption('brute-force'));
  }

  #[Test]
  public function commandRunsWithoutArgumentAndOption(): void
  {
    $command = $this->get(CommandRegistry::class)->get('myextension:createwizard');

    self::assertSame(Command::SUCCESS, (new CommandTester($command))->execute([]));
  }
}
