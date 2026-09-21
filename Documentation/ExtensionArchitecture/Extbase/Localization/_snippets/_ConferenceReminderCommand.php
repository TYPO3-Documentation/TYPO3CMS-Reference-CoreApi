<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Command;

use MyVendor\MyExtension\Domain\Repository\ConferenceRepository;
use MyVendor\MyExtension\Domain\Repository\FrontendUserRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TYPO3\CMS\Core\Context\LanguageAspectFactory;
use TYPO3\CMS\Core\Site\SiteFinder;

#[AsCommand(
  name: 'myextension:conferencereminder',
  description: 'Mail all frontend users a reminder in their own language',
)]
class ConferenceReminderCommand extends Command
{
  public function __construct(
    protected readonly ConferenceRepository $conferenceRepository,
    protected readonly FrontendUserRepository $frontendUserRepository,
    protected readonly SiteFinder $siteFinder,
  ) {
    parent::__construct();
  }

  protected function execute(InputInterface $input, OutputInterface $output): int
  {
    // There is no site in a command, so the site the mails belong to has
    // to be named explicitly.
    $site = $this->siteFinder->getSiteByIdentifier('my-site');

    foreach ($this->frontendUserRepository->findAll() as $user) {
      // for sake of this example the user record provides a chosen language
      // in line with the site configuration
      $siteLanguage = $site->getLanguageById($user->getLanguageId());

      // The language's own configuration, exactly as the frontend of
      // this site would apply it.
      $languageAspect = LanguageAspectFactory::createFromSiteLanguage($siteLanguage);

      $conferences = $this->conferenceRepository
          ->findAllForLanguageAspect($languageAspect);

      // Send the mail, using $conferences and $siteLanguage->getLocale()
    }

    return Command::SUCCESS;
  }
}
