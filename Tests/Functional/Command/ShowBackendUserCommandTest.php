<?php

declare(strict_types=1);

namespace T3docs\ReferenceCoreApi\Tests\Functional\Command;

use PHPUnit\Framework\Attributes\Test;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;
use TYPO3\CMS\Core\Authentication\CommandLineUserAuthentication;
use TYPO3\CMS\Core\Console\CommandRegistry;
use TYPO3\CMS\Core\Core\Bootstrap;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

/**
 * Checks the command that initializes a backend user on the page on custom
 * commands.
 */
final class ShowBackendUserCommandTest extends FunctionalTestCase
{
  protected array $testExtensionsToLoad = [
    'myvendor/my-extension',
  ];

  #[Test]
  public function commandRunsAsTheAdministratorCliUser(): void
  {
    // The typo3 binary does this before it runs a command
    Bootstrap::initializeBackendUser(CommandLineUserAuthentication::class);
    $command = $this->get(CommandRegistry::class)->get('myextension:showbackenduser');
    $commandTester = new CommandTester($command);

    self::assertSame(Command::SUCCESS, $commandTester->execute([]));
    self::assertSame(
      'Running as backend user "_cli_", an administrator.',
      trim($commandTester->getDisplay()),
    );
  }
}
