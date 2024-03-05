<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Backend\EventListener;

use TYPO3\CMS\Backend\Search\Event\ModifyQueryForLiveSearchEvent;
use TYPO3\CMS\Core\Attribute\AsEventListener;

#[AsEventListener(
    identifier: 'my-extension/modify-query-for-live-search-event-listener',
)]
final readonly class MyEventListener
{
    public function __invoke(ModifyQueryForLiveSearchEvent $event): void
    {
        // Get the current instance
        $queryBuilder = $event->getQueryBuilder();

        // Change limit depending on the table
        if ($event->getTableName() === 'pages') {
            $queryBuilder->setMaxResults(2);
        }

        // Reset the orderBy part
        $queryBuilder->resetQueryPart('orderBy');
    }
}
