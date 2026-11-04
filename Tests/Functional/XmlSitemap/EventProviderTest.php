<?php

declare(strict_types=1);

namespace T3docs\ReferenceCoreApi\Tests\Functional\XmlSitemap;

use PHPUnit\Framework\Attributes\Test;
use TYPO3\CMS\Core\Configuration\SiteWriter;
use TYPO3\TestingFramework\Core\Functional\Framework\Frontend\InternalRequest;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

/**
 * Checks the data provider of the event sitemap and its registration in
 * TypoScript, on the page on the XML sitemap.
 */
final class EventProviderTest extends FunctionalTestCase
{
  protected array $coreExtensionsToLoad = [
    'seo',
  ];

  protected array $testExtensionsToLoad = [
    'myvendor/my-extension',
  ];

  protected function setUp(): void
  {
    parent::setUp();
    $this->importCSVDataSet(__DIR__ . '/Fixtures/Events.csv');
    $this->get(SiteWriter::class)->createNewBasicSite(
      'main',
      1,
      'https://www.example.org/',
      ['myvendor/my-extension'],
    );
  }

  #[Test]
  public function sitemapListsTheEventsOfTheConfiguredPage(): void
  {
    // The sitemap index links the sitemap of the events
    $index = (string)$this->executeFrontendSubRequest(
      new InternalRequest('https://www.example.org/sitemap.xml'),
    )->getBody();
    $pattern = '#<loc>(https://[^<]*events[^<]*)</loc>#';
    $eventsUrl = preg_match($pattern, $index, $matches) === 1
      ? html_entity_decode($matches[1])
      : '';
    self::assertNotSame('', $eventsUrl, $index);

    $response = $this->executeFrontendSubRequest(
      new InternalRequest($eventsUrl),
    );
    $xml = (string)$response->getBody();

    self::assertSame(200, $response->getStatusCode(), $xml);
    self::assertSame(2, substr_count($xml, '<url>'), $xml);
    // The mapper adds the URL of the detail page to each item
    $detailUrl = 'https://www.example.org/event'
      . '?tx_myextension_event%5Bevent%5D=';
    self::assertStringContainsString('<loc>' . $detailUrl . '1&amp;', $xml);
    self::assertStringContainsString('<loc>' . $detailUrl . '2&amp;', $xml);
  }
}
