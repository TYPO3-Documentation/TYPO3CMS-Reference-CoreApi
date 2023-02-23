<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Backend\EventListener;

use TYPO3\CMS\Backend\View\Event\ModifyDatabaseQueryForRecordListingEvent;

final class MyEventListener
{
    public function __invoke(ModifyDatabaseQueryForRecordListingEvent $event): void
    {
        $queryBuilder = $event->getQueryBuilder();

        // ... do something ...

        $event->setQueryBuilder($queryBuilder);
    }
}
