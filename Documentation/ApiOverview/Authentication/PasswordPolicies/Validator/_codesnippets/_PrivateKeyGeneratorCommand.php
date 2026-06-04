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
    name: 'myextension:generateprivatekey',
    description: 'Generates an encrypted private key',
)]
final class PrivateKeyGeneratorCommand extends Command
{
    // Implement class MyService
    public function __construct(private readonly MyService $myService)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $passwort = (string)$io->askHidden(
            'Please enter the password to encrypt the key',
        );
        $passwordValidator = new PasswordPolicyValidator(PasswordPolicyAction::NEW_USER_PASSWORD);
        $result = $passwordValidator->isValidPassword($passwort);
        if ($result === true) {
            $this->myService->generatePrivateKey($passwort);
            return Command::SUCCESS;
        }
        $io->error('The password must adhere to the default password policy.');
        return Command::FAILURE;
    }
}
