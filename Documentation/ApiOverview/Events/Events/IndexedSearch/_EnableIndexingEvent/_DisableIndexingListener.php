<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\IndexedSearch\Event\EnableIndexingEvent;

#[AsEventListener(
  identifier: 'my-extension/disable-indexing-of-filtered-lists',
)]
final readonly class DisableIndexingListener
{
  public function __invoke(EnableIndexingEvent $event): void
  {
    $queryParams = $event->getRequest()->getQueryParams();
    // Do not index list views that are filtered by GET parameters
    if (isset($queryParams['tx_myextension_list']['filter'])) {
      $event->disableIndexing();
    }
  }
}
