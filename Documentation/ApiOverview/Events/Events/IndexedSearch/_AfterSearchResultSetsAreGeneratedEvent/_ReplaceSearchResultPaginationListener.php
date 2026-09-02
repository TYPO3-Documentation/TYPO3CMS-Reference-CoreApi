<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Core\Pagination\SimplePagination;
use TYPO3\CMS\Core\Pagination\SlidingWindowPagination;
use TYPO3\CMS\IndexedSearch\Event\AfterSearchResultSetsAreGeneratedEvent;

#[AsEventListener(identifier: 'my-extension/replace-search-result-pagination')]
final readonly class ReplaceSearchResultPaginationListener
{
    public function __invoke(AfterSearchResultSetsAreGeneratedEvent $event): void
    {
        $resultSets = $event->getResultSets();
        foreach ($resultSets as $key => $resultSet) {
            if (($resultSet['pagination'] ?? null) instanceof SimplePagination) {
                $resultSets[$key]['pagination'] = new SlidingWindowPagination(
                    $resultSet['pagination']->getPaginator(),
                    5,
                );
            }
        }
        $event->setResultSets($resultSets);
    }
}
