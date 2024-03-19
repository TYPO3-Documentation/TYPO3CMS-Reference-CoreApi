<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use TYPO3\CMS\Core\PasswordPolicy\PasswordPolicyAction;
use TYPO3\CMS\Core\PasswordPolicy\PasswordPolicyValidator;

#[AsCommand(
    name: 'myextension:createPassword',
    description: 'Enter a password',
)]
final class PasswordCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $passwort = (string)$io->askHidden(
            'Please enter the new password',
        );
        $passwordValidator = new PasswordPolicyValidator(PasswordPolicyAction::NEW_USER_PASSWORD);
        $result = $passwordValidator->isValidPassword($passwort);
        if ($result === true) {
            return Command::SUCCESS;
        }
        $io->error('The password must be at least 8 chars long and contain upper case and lower case letters.');
        return Command::FAILURE;
    }
}
