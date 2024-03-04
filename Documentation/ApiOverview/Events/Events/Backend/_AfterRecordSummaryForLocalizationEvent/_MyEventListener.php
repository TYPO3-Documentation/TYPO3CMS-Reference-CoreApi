<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Backend\EventListener;

use TYPO3\CMS\Backend\Controller\Event\AfterRecordSummaryForLocalizationEvent;
use TYPO3\CMS\Core\Attribute\AsEventListener;

#[AsEventListener(
    identifier: 'my-extension/backend/after-record-summary-for-localization',
)]
final readonly class MyEventListener
{
    public function __invoke(AfterRecordSummaryForLocalizationEvent $event): void
    {
        // Get current records
        $records = $event->getRecords();

        // ... do something with $records

        // Set new records
        $event->setRecords($records);

        // Get current columns
        $columns = $event->getColumns();

        // ... do something with $columns

        // Set new columns
        $event->setColumns($columns);
    }
}
