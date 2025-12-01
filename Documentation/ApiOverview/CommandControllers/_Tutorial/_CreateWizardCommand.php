<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use T3docs\Examples\Exception\InvalidWizardException;
use TYPO3\CMS\Core\Attribute\AsNonSchedulableCommand;

#[AsCommand(
    name: 'myextension:createwizard',
)]
#[AsNonSchedulableCommand]
final class CreateWizardCommand extends Command
{
    protected function configure(): void
    {
        $this
            ->setHelp('This command accepts arguments')
            ->addArgument(
                'wizardName',
                InputArgument::OPTIONAL,
                'The wizard\'s name',
            )
            ->addOption(
                'brute-force',
                'b',
                InputOption::VALUE_NONE,
                'Allow the "Wizard of Oz". You can use --brute-force or -b when running command',
            );
    }
    protected function execute(
        InputInterface $input,
        OutputInterface $output,
    ): int {
        $io = new SymfonyStyle($input, $output);
        $wizardName = $input->getArgument('wizardName');
        $bruteForce = (bool)$input->getOption('brute-force');
        try {
            $this->doMagic($io, $wizardName, $bruteForce);
        } catch (InvalidWizardException) {
            return Command::FAILURE;
        }
        return Command::SUCCESS;
    }

    private function doMagic(SymfonyStyle $io, mixed $wizardName, bool $bruteForce): void
    {
        // do your magic here
    }
}
