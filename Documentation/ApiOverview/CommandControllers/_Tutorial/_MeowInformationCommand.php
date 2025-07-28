<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Command;

use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use T3docs\Examples\Http\MeowInformationRequester;
#[AsCommand(
    name: 'myextension:dosomething',
)]
final class MeowInformationCommand extends Command
{
    public function __construct(
        private readonly MeowInformationRequester $requester,
        private readonly LoggerInterface $logger,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if (!$this->requester->isReady()) {
            $this->logger->error('MeowInformationRequester was not ready! ');
            return Command::SUCCESS;
        }
        // Do awesome stuff
        return Command::SUCCESS;
    }
}
