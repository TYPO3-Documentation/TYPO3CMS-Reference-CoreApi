<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'myextension:dosomething',
    description: 'A command that does nothing and always succeeds.',
    aliases: ['examples:dosomethingalias'],
)]
class DoSomethingCommand extends Command
{
    protected function configure(): void
    {
        $this->setHelp('This command does nothing. It always succeeds.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->info('Command needs to be implemented. ');
        return Command::SUCCESS;
    }
}
