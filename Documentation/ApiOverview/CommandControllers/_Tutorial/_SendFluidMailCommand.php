<?php

declare(strict_types=1);

namespace T3docs\Examples\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TYPO3\CMS\Core\Core\Bootstrap;
use TYPO3\CMS\Core\Core\SystemEnvironmentBuilder;
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
    Bootstrap::initializeBackendAuthentication();

    // The site has to have a fully qualified domain name
    $site = $this->siteFinder->getSiteByPageId(1);
    $request = (new ServerRequest())
        ->withAttribute('applicationType', SystemEnvironmentBuilder::REQUESTTYPE_FE)
        ->withAttribute('site', $site);
    $GLOBALS['TYPO3_REQUEST'] = $request;
    // Send some mails with FluidEmail. Commands use create(), which reads
    // the global mail configuration. Passing the request keeps link
    // generation working.
    $email = $this->templatedEmailFactory->create($request);
    // Set receiver etc
    $this->mailer->send($email);
    return Command::SUCCESS;
  }
}
