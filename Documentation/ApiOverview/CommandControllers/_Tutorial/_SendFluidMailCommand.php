<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TYPO3\CMS\Core\Core\SystemEnvironmentBuilder;
use TYPO3\CMS\Core\Http\NormalizedParams;
use TYPO3\CMS\Core\Http\ServerRequest;
use TYPO3\CMS\Core\Mail\MailerInterface;
use TYPO3\CMS\Core\Mail\TemplatedEmailFactory;
use TYPO3\CMS\Core\Site\SiteFinder;

#[AsCommand(
  name: 'myextension:sendmail',
)]
class SendFluidMailCommand extends Command
{
  public function __construct(
    private readonly SiteFinder $siteFinder,
    private readonly MailerInterface $mailer,
    private readonly TemplatedEmailFactory $templatedEmailFactory,
  ) {
    parent::__construct();
  }

  protected function execute(InputInterface $input, OutputInterface $output): int
  {
    // The site has to have a fully qualified domain name
    $site = $this->siteFinder->getSiteByPageId(1);
    // Simulate a frontend request to the site, so that links and resources
    // in the email point to the site
    $request = (new ServerRequest($site->getBase()))
      ->withAttribute(
        'applicationType',
        SystemEnvironmentBuilder::REQUESTTYPE_FE,
      )
      ->withAttribute('site', $site);
    // FluidEmail needs normalizedParams on the request, see
    // https://forge.typo3.org/issues/111023
    $request = $request->withAttribute(
      'normalizedParams',
      NormalizedParams::createFromRequest($request),
    );
    // Commands use create(), which reads the global mail configuration
    $email = $this->templatedEmailFactory->create($request);
    // Set receiver etc
    $this->mailer->send($email);
    return Command::SUCCESS;
  }
}
