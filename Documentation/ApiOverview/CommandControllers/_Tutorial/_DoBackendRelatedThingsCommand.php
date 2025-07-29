<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TYPO3\CMS\Core\Core\Bootstrap;

#[AsCommand(
    name: 'myextension:dosomething',
)]
final class DoBackendRelatedThingsCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        Bootstrap::initializeBackendAuthentication();
        // Do backend related stuff

        return Command::SUCCESS;
    }
}
