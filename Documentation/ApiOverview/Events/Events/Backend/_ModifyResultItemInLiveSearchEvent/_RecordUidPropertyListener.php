<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Backend\EventListener;

use TYPO3\CMS\Backend\Search\Event\ModifyResultItemInLiveSearchEvent;
use TYPO3\CMS\Backend\Search\LiveSearch\DatabaseRecordProvider;
use TYPO3\CMS\Core\Attribute\AsEventListener;

#[AsEventListener(
  identifier: 'my-extension/live-search-record-uid',
)]
final readonly class RecordUidPropertyListener
{
  public function __invoke(ModifyResultItemInLiveSearchEvent $event): void
  {
    $resultItem = $event->getResultItem();
    $provider = $resultItem->getProviderClassName();
    if ($provider !== DatabaseRecordProvider::class) {
      return;
    }
    $extraData = $resultItem->getExtraData();
    if (($extraData['table'] ?? null) !== 'tt_content') {
      return;
    }
    // Shown in the detail panel of the result
    $resultItem->addProperty('Record UID', (string)$extraData['uid']);
  }
}
