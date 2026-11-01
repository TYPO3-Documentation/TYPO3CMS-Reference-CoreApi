<?php

declare(strict_types=1);

namespace T3docs\ReferenceCoreApi\Tests\Functional\ContentElements;

use PHPUnit\Framework\Attributes\Test;
use TYPO3\CMS\Core\Configuration\SiteWriter;
use TYPO3\TestingFramework\Core\Functional\Framework\Frontend\InternalRequest;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

/**
 * Renders the content elements of the page about adding your own content
 * elements, with the TypoScript of the set of the extension.
 */
final class CustomContentElementTest extends FunctionalTestCase
{
  protected array $coreExtensionsToLoad = [
    'fluid_styled_content',
  ];

  protected array $testExtensionsToLoad = [
    'myvendor/my-extension',
  ];

  protected function setUp(): void
  {
    parent::setUp();
    $this->importCSVDataSet(__DIR__ . '/Fixtures/ContentElements.csv');
    $this->get(SiteWriter::class)->createNewBasicSite(
      'main',
      1,
      'https://www.example.org/',
    );
    $this->setUpFrontendRootPage(1, [
      'EXT:fluid_styled_content/Configuration/TypoScript/setup.typoscript',
      'EXT:my_extension/Configuration/Sets/Main/setup.typoscript',
    ]);
    $this->addTypoScriptToTemplateRecord(
      1,
      'page = PAGE' . LF . 'page.10 < styles.content.get',
    );
  }

  #[Test]
  public function basicContentShowsItsText(): void
  {
    // f:format.html wraps the text in a paragraph
    self::assertStringContainsString(
      '<div><p>The text of the basic content element</p></div>',
      $this->renderPage(),
    );
  }

  #[Test]
  public function tableFromCsvSplitsTheTextAtTheSeparator(): void
  {
    $html = $this->renderPage();

    self::assertStringContainsString(
      'Output, 2 columns separated by char',
      $html,
    );
    self::assertMatchesRegularExpression(
      '#<th scope="row">2</th>\s*<td>Apple</td>\s*<td>Green</td>#',
      $html,
    );
  }

  private function renderPage(): string
  {
    $response = $this->executeFrontendSubRequest(
      new InternalRequest('https://www.example.org/'),
    );
    self::assertSame(200, $response->getStatusCode());

    return (string)$response->getBody();
  }
}
