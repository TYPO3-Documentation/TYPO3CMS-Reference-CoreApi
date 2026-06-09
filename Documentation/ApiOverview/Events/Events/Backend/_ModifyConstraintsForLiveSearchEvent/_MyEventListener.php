<?php

declare(strict_types=1);

namespace MyVendor\MyPackage\Backend\Search\EventListener;

use TYPO3\CMS\Backend\Search\Event\ModifyConstraintsForLiveSearchEvent;
use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Core\Database\ConnectionPool;

final readonly class MyEventListener
{
    public function __construct(private ConnectionPool $connectionPool) {}

    #[AsEventListener('my-package/livesearch-enhanced')]
    public function __invoke(ModifyConstraintsForLiveSearchEvent $event): void
    {
        if ($event->getTableName() !== 'pages') {
            return;
        }

        $queryBuilder = $this->connectionPool->getQueryBuilderForTable('pages');
        // Add a constraint so that pages marked with "show_in_all_results=1"
        // will always be shown.
        $constraints[] = $queryBuilder->expr()->eq(
            'show_in_all_results',
            1,
        );

        $event->addConstraints(...$constraints);
    }
}
