<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TYPO3\CMS\Core\Registry;

#[AsCommand(
  name: 'myextension:recordlastrun',
  description: 'Writes the start and end time of its run into the registry',
)]
final class RecordLastRunCommand extends Command
{
  private int $startTime;

  public function __construct(
    private readonly Registry $registry,
  ) {
    parent::__construct();
  }

  protected function execute(InputInterface $input, OutputInterface $output): int
  {
    $this->startTime = \time();

    // ... some logic

    $this->writeIntoRegistry();

    return Command::SUCCESS;
  }

  private function writeIntoRegistry(): void
  {
    $runInformation = [
      'startTime' => $this->startTime,
      'endTime' => time(),
    ];

    $this->registry->set('tx_myextension', 'lastRun', $runInformation);
  }
}
