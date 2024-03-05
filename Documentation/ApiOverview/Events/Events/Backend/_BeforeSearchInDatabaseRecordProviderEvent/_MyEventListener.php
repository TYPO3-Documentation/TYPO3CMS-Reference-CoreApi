<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Backend\EventListener;

use TYPO3\CMS\Backend\Search\Event\BeforeSearchInDatabaseRecordProviderEvent;
use TYPO3\CMS\Core\Attribute\AsEventListener;

#[AsEventListener(
    identifier: 'my-extension/before-search-in-database-record-provider',
)]
final readonly class MyEventListener
{
    public function __invoke(BeforeSearchInDatabaseRecordProviderEvent $event): void
    {
        $event->ignoreTable('my_custom_table');
    }
}
