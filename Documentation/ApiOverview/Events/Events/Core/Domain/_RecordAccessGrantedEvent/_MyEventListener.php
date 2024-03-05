<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Access;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Core\Domain\Access\RecordAccessGrantedEvent;

#[AsEventListener(
    identifier: 'my-extension/set-access-granted',
)]
final readonly class MyEventListener
{
    public function __invoke(RecordAccessGrantedEvent $event): void
    {
        // Manually set access granted
        if (
            $event->getTable() === 'my_table' &&
            ($event->getRecord()['custom_access_field'] ?? false)
        ) {
            $event->setAccessGranted(true);
        }

        // Update the record to be checked
        $record = $event->getRecord();
        $record['some_field'] = true;
        $event->updateRecord($record);
    }
}
