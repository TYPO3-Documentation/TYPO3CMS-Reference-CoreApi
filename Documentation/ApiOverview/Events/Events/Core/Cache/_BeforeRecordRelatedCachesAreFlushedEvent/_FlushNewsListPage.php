<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Core\Cache\Event\BeforeRecordRelatedCachesAreFlushedEvent;

final readonly class FlushNewsListPage
{
  // The page that lists the news records
  private const NEWS_LIST_PAGE = 42;

  #[AsEventListener('my-extension/flush-news-list-page')]
  public function __invoke(BeforeRecordRelatedCachesAreFlushedEvent $event): void
  {
    if ($event->table === 'tx_myextension_news') {
      $event->addPageId(self::NEWS_LIST_PAGE);
    }
  }
}
