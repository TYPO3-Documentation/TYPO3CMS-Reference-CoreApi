<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Backend\EventListener;

use TYPO3\CMS\Backend\RecordList\Event\BeforeRecordDownloadIsExecutedEvent;
use TYPO3\CMS\Core\Attribute\AsEventListener;

#[AsEventListener(identifier: 'my-package/record-list-download-data')]
final readonly class DataListener
{
    public function __invoke(BeforeRecordDownloadIsExecutedEvent $event): void
    {
        // List of redactable fields.
        $gdprFields = ['title', 'author'];

        $headerRow = $event->getHeaderRow();
        $records = $event->getRecords();

        // Iterate header to mark redacted fields...
        foreach ($headerRow as $headerRowKey => $headerRowValue) {
            if (in_array($headerRowKey, $gdprFields, true)) {
                $headerRow[$headerRowKey] .= ' (REDACTED)';
            }
        }

        // Redact actual content...
        foreach ($records as $index => $record) {
            foreach ($gdprFields as $gdprField) {
                if (isset($record[$gdprField])) {
                    $records[$index][$gdprField] = '(REDACTED)';
                }
            }
        }

        $event->setHeaderRow($headerRow);
        $event->setRecords($records);
    }
}
