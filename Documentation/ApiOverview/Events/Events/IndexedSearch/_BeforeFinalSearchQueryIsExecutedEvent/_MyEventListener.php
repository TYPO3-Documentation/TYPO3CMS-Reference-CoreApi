<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\IndexedSearch\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\IndexedSearch\Event\BeforeFinalSearchQueryIsExecutedEvent;

final readonly class EventListener
{
    #[AsEventListener(identifier: 'manipulate-search-query')]
    public function beforeFinalSearchQueryIsExecuted(BeforeFinalSearchQueryIsExecutedEvent $event): void
    {
        $event->queryBuilder->andWhere(
            $event->queryBuilder->expr()->eq('some_column', 'some_value'),
        );
    }
}
