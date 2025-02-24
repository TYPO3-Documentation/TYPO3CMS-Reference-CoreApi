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
use TYPO3\CMS\Core\Mail\FluidEmail;
use TYPO3\CMS\Core\Mail\MailerInterface;
use TYPO3\CMS\Core\Site\SiteFinder;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;

#[AsCommand(
    name: 'examples:dosomething',
    description: 'A command that does nothing and always succeeds.',
    aliases: ['examples:dosomethingalias'],
)]
class DoSomethingCommand extends Command
{
    public function __construct(
        private readonly ConfigurationManagerInterface $configurationManager,
        private readonly SiteFinder $siteFinder,
        private readonly MailerInterface $mailer,
        private readonly ExampleRepository $exampleRepository,
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
        // Needed if Extbase Repositories should be usable
        $this->configurationManager->setRequest($request);
        $someExampleInfo = $this->exampleRepository->findByUid(42);
        // Send some mails with FluidEmail
        $email = new FluidEmail();
        $email->setRequest($request);
        $email->assign('exampleInfo', $someExampleInfo);
        // Set receiver etc
        $this->mailer->send($email);
        return Command::SUCCESS;
    }
}
