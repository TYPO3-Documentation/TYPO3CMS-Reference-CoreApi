<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Backend\EventListener;

use TYPO3\CMS\Backend\View\Event\ModifyDatabaseQueryForRecordListingEvent;
use TYPO3\CMS\Core\Attribute\AsEventListener;

#[AsEventListener(
    identifier: 'my-extension/backend/modify-database-query-for-record-list',
)]
final readonly class MyEventListener
{
    public function __invoke(ModifyDatabaseQueryForRecordListingEvent $event): void
    {
        $queryBuilder = $event->getQueryBuilder();

        // ... do something ...

        $event->setQueryBuilder($queryBuilder);
    }
}
