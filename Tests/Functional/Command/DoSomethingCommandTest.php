<?php

declare(strict_types=1);

namespace T3docs\ReferenceCoreApi\Tests\Functional\Command;

use PHPUnit\Framework\Attributes\Test;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;
use TYPO3\CMS\Core\Console\CommandRegistry;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

/**
 * Checks the command of the tutorial "Create a console command from scratch".
 */
final class DoSomethingCommandTest extends FunctionalTestCase
{
  protected array $testExtensionsToLoad = [
    'myvendor/my-extension',
  ];

  #[Test]
  public function commandIsRegisteredWithNameAndAlias(): void
  {
    $commandRegistry = $this->get(CommandRegistry::class);
    self::assertTrue($commandRegistry->has('myextension:dosomething'));
    self::assertTrue($commandRegistry->has('myextension:dosomethingalias'));
  }

  #[Test]
  public function commandPrintsANoteAndSucceeds(): void
  {
    $command = $this->get(CommandRegistry::class)->get('myextension:dosomething');
    $commandTester = new CommandTester($command);

    self::assertSame(Command::SUCCESS, $commandTester->execute([]));
    self::assertStringContainsString('Command needs to be implemented.', $commandTester->getDisplay());
  }
}
