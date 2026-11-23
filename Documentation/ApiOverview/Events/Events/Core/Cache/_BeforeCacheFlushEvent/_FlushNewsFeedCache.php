<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Core\Cache\Event\BeforeCacheFlushEvent;

final readonly class FlushNewsFeedCache
{
  #[AsEventListener('my-extension/flush-news-feed-cache')]
  public function __invoke(BeforeCacheFlushEvent $event): void
  {
    // The RSS feed of the news is cached with this tag
    if ($event->plan->hasRecordOfTable('tx_myextension_news')) {
      $event->plan->addTag('tx_myextension_feed');
    }
  }
}
