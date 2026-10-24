<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Command;

use MyVendor\MyExtension\Http\MeowInformationRequester;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
  name: 'myextension:meowinformation',
  description: 'Prints a random fact about cats.',
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
    try {
      $fact = $this->requester->request();
    } catch (\RuntimeException|\JsonException $e) {
      $this->logger->error('No cat fact: ' . $e->getMessage());
      return Command::FAILURE;
    }
    $output->writeln($fact);
    return Command::SUCCESS;
  }
}
