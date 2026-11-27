<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\EventListener;

use MyVendor\MyExtension\Search\SearchServerClient;
use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Core\Cache\Event\CacheFlushEvent;

final readonly class FlushSearchIndexCache
{
  public function __construct(
    private SearchServerClient $searchServerClient,
  ) {}

  #[AsEventListener('my-extension/flush-search-index-cache')]
  public function __invoke(CacheFlushEvent $event): void
  {
    if (!$event->hasGroup('all') && !$event->hasGroup('pages')) {
      return;
    }
    if (!$this->searchServerClient->flushCache()) {
      $event->addError('The cache of the search server could not be flushed.');
    }
  }
}
