<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Command;

use MyVendor\MyExtension\Domain\Repository\ConferenceRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use TYPO3\CMS\Core\Domain\Repository\PageRepository;
use TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface;

#[AsCommand(
  name: 'myextension:unpublishpast',
  description: 'Unpublish conferences that have taken place',
)]
class UnpublishPastConferencesCommand extends Command
{
  public function __construct(
    protected readonly ConferenceRepository $conferenceRepository,
    protected readonly PersistenceManagerInterface $persistenceManager,
    protected readonly PageRepository $pageRepository,
  ) {
    parent::__construct();
  }

  protected function configure(): void
  {
    $this
      ->addArgument(
        'storagePid',
        InputArgument::REQUIRED,
        'Folder that stores the conferences',
      )
      ->addOption(
        'depth',
        null,
        InputOption::VALUE_REQUIRED,
        'Number of page levels below the folder to include',
        '0',
      );
  }

  protected function execute(
    InputInterface $input,
    OutputInterface $output,
  ): int {
    $storagePageIds = $this->pageRepository->getPageIdsRecursive(
      [(int)$input->getArgument('storagePid')],
      (int)$input->getOption('depth'),
    );
    $conferences = $this->conferenceRepository->findPublishedBefore(
      new \DateTimeImmutable('today'),
      $storagePageIds,
    );

    $count = 0;
    foreach ($conferences as $conference) {
      $conference->setPublished(false);
      $this->conferenceRepository->update($conference);
      $count++;
    }
    // No Extbase request ends here, so nothing else writes the changes
    $this->persistenceManager->persistAll();

    $output->writeln(sprintf('%d conferences unpublished.', $count));
    return Command::SUCCESS;
  }
}
