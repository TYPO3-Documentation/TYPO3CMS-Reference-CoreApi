<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Core\SystemEnvironmentBuilder;
use TYPO3\CMS\Core\Http\NormalizedParams;
use TYPO3\CMS\Core\Http\ServerRequest;
use TYPO3\CMS\Core\Mail\MailerInterface;
use TYPO3\CMS\Core\Mail\TemplatedEmailFactory;
use TYPO3\CMS\Core\Site\SiteFinder;

#[AsCommand(
  name: 'myextension:sendmail',
  description: 'Sends the weekly report as a FluidEmail',
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
    $base = $site->getBase();
    $request = (new ServerRequest($base, 'GET', null, [], [
      'HTTP_HOST' => $base->getHost(),
      'HTTPS' => $base->getScheme() === 'https' ? 'on' : 'off',
      'SCRIPT_NAME' => '/index.php',
    ]))
      ->withAttribute(
        'applicationType',
        SystemEnvironmentBuilder::REQUESTTYPE_FE,
      )
      ->withAttribute('site', $site);
    // FluidEmail needs normalizedParams on the request, see
    // https://forge.typo3.org/issues/111023. A command is not started by
    // the index.php of the public folder, so name it as the entry script.
    $request = $request->withAttribute(
      'normalizedParams',
      new NormalizedParams(
        $request->getServerParams(),
        $GLOBALS['TYPO3_CONF_VARS']['SYS'],
        Environment::getPublicPath() . '/index.php',
        Environment::getPublicPath(),
      ),
    );
    // Commands use create(), which reads the global mail configuration
    $email = $this->templatedEmailFactory->create($request)
      ->to('editor@example.org')
      ->subject('Weekly report')
      ->assign('headline', 'Weekly report')
      ->assign('content', 'All scheduled tasks ran without errors.');
    $this->mailer->send($email);
    return Command::SUCCESS;
  }
}
