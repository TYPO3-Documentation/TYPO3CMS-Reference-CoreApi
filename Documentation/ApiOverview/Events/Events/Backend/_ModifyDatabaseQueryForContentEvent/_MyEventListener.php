<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Backend\EventListener;

use TYPO3\CMS\Backend\View\Event\ModifyDatabaseQueryForContentEvent;
use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Core\Database\Connection;

#[AsEventListener(
    identifier: 'my-extension/backend/modify-database-query-for-content',
)]
final readonly class MyEventListener
{
    public function __invoke(ModifyDatabaseQueryForContentEvent $event): void
    {
        // Early return if we do not need to react
        if ($event->getTable() !== 'tt_content') {
            return;
        }

        // Retrieve QueryBuilder instance from event
        $queryBuilder = $event->getQueryBuilder();

        // Add an additional condition to the QueryBuilder for the table
        // Note: This is only a example, modify the QueryBuilder instance
        //       here to your needs.
        $queryBuilder = $queryBuilder->andWhere(
            $queryBuilder->expr()->neq(
                'some_field',
                $queryBuilder->createNamedParameter(1, Connection::PARAM_INT),
            ),
        );

        // Set updated QueryBuilder to event
        $event->setQueryBuilder($queryBuilder);
    }
}
