<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Service;

use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\Typolink\LinkFactory;
use TYPO3\CMS\Frontend\Typolink\LinkResultInterface;

readonly class MyLinkService
{
  public function __construct(
    protected LinkFactory $linkFactory,
  ) {}

  /**
   * Build a page link with nested query parameters.
   */
  public function articleLink(
    ContentObjectRenderer $contentObjectRenderer,
  ): LinkResultInterface {
    return $this->linkFactory->create(
      'Read the article',
      [
        'parameter' => 't3://page?uid=42',
        'queryParameters' => [
          'tx_news' => [
            'action' => 'show',
            'id' => 123,
          ],
        ],
      ],
      $contentObjectRenderer,
    );
  }
}
