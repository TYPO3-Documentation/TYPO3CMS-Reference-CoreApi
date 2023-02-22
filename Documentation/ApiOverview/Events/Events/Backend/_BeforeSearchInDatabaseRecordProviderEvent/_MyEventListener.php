<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Backend\EventListener;

use TYPO3\CMS\Backend\Search\Event\BeforeSearchInDatabaseRecordProviderEvent;

final class MyEventListener
{
    public function __invoke(BeforeSearchInDatabaseRecordProviderEvent $event): void
    {
        $event->ignoreTable('my_custom_table');
    }
}
