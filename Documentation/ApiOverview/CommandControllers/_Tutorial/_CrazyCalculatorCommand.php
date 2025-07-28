<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'myextension:crazycalculator',
)]
final class CrazyCalculatorCommand extends Command
{
    protected function execute(
        InputInterface $input,
        OutputInterface $output,
    ): int {
        $io = new SymfonyStyle($input, $output);
        $io->title('Welcome to our awesome extension');

        $io->text([
            'We will ask some questions.',
            'Please take your time to answer them.',
        ]);
        do {
            $number = (int)$io->ask(
                'Please enter a number greater 0',
                '42',
            );
        } while ($number <= 0);
        $operation = (string)$io->choice(
            'Chose the desired operation',
            ['squared', 'divided by 0'],
            'squared',
        );
        switch ($operation) {
            case 'squared':
                $io->success(sprintf('%d squared is %d', $number, $number * $number));
                return Command::SUCCESS;
            default:
                $io->error('Operation ' . $operation . 'is not supported. ');
                return Command::FAILURE;
        }
    }
}
