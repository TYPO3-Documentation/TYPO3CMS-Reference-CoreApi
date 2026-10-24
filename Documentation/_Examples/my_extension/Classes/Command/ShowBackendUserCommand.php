<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TYPO3\CMS\Core\Core\Bootstrap;

#[AsCommand(
  name: 'myextension:showbackenduser',
  description: 'Shows the backend user the command runs as.',
)]
final class ShowBackendUserCommand extends Command
{
  protected function execute(InputInterface $input, OutputInterface $output): int
  {
    Bootstrap::initializeBackendAuthentication();
    $backendUser = $GLOBALS['BE_USER'];

    $output->writeln(sprintf(
      'Running as backend user "%s"%s.',
      $backendUser->getUserName(),
      $backendUser->isAdmin() ? ', an administrator' : '',
    ));
    return Command::SUCCESS;
  }
}
