<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Repository;

use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;

final readonly class MyDbalRepository
{
    public function __construct(
        private ConnectionPool $connectionPool,
    ) {}

    // DO
    public function findBySearchWord(string $searchWord): void
    {
        $queryBuilder = $this->connectionPool
            ->getQueryBuilderForTable('tt_content');
        $queryBuilder->getRestrictions()->removeAll();
        $queryBuilder
            ->select('uid')
            ->from('tt_content')
            ->where(
                $queryBuilder->expr()->eq(
                    'bodytext',
                    $queryBuilder->createNamedParameter(
                        $searchWord,
                        Connection::PARAM_STR,
                    ),
                ),
            );
    }

    // DON'T DO, this is much harder to track:
    public function findBySearchWordHardToTrack(string $searchWord): void
    {
        $queryBuilder = $this->connectionPool
            ->getQueryBuilderForTable('tt_content');
        $myValue = $queryBuilder->createNamedParameter($searchWord);
        // Imagine much more code here
        $queryBuilder->getRestrictions()->removeAll();
        $queryBuilder
            ->select('uid')
            ->from('tt_content')
            ->where(
                $queryBuilder->expr()->eq('bodytext', $myValue),
            );
    }
}
