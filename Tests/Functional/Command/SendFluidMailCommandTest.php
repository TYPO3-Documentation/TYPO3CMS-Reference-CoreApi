<?php

declare(strict_types=1);

namespace T3docs\ReferenceCoreApi\Tests\Functional\Command;

use PHPUnit\Framework\Attributes\Test;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;
use TYPO3\CMS\Core\Configuration\SiteWriter;
use TYPO3\CMS\Core\Console\CommandRegistry;
use TYPO3\CMS\Core\Mail\FluidEmail;
use TYPO3\CMS\Core\Mail\MailerInterface;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

/**
 * Checks the command that sends a FluidEmail with a simulated frontend
 * request, on the pages on custom commands and on the command tutorial.
 * The null transport keeps the email, so the test can read it.
 */
final class SendFluidMailCommandTest extends FunctionalTestCase
{
  protected array $testExtensionsToLoad = [
    'my-vendor/my-extension',
  ];

  protected array $configurationToUseInTestInstance = [
    'MAIL' => [
      'transport' => 'null',
      'defaultMailFromAddress' => 'noreply@example.org',
    ],
  ];

  #[Test]
  public function commandSendsAnEmailThatPointsToTheSite(): void
  {
    $this->importCSVDataSet(__DIR__ . '/Fixtures/SiteRoot.csv');
    $this->get(SiteWriter::class)->createNewBasicSite(
      'main',
      1,
      'https://www.example.org/',
    );

    $commandTester = new CommandTester(
      $this->get(CommandRegistry::class)->get('myextension:sendmail'),
    );

    self::assertSame(Command::SUCCESS, $commandTester->execute([]));

    $email = $this->get(MailerInterface::class)
      ->getSentMessage()
      ?->getOriginalMessage();
    self::assertInstanceOf(FluidEmail::class, $email);
    self::assertSame('editor@example.org', $email->getTo()[0]->getAddress());
    self::assertSame('Weekly report', $email->getSubject());
    self::assertStringContainsString(
      'All scheduled tasks ran without errors.',
      (string)$email->getHtmlBody(),
    );
    // The layout of the email names the URL of the site that sent it
    self::assertStringContainsString(
      'from URL: <a href="https://www.example.org/"',
      (string)$email->getHtmlBody(),
    );
  }
}
