<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Repository;

use TYPO3\CMS\Core\Database\ConnectionPool;

final class MyTableRepository
{
    private const TABLE_NAME = 'tt_content';

    public function __construct(
        private readonly ConnectionPool $connectionPool
    ) {
    }

    public function findSomething()
    {
        $queryBuilder = $this->connectionPool->getQueryBuilderForTable(self::TABLE_NAME);

        $rows = $queryBuilder
            ->select('uid', 'header', 'bodytext')
            ->from(self::TABLE_NAME)
            ->where(
                // `bodytext` = 'klaus' AND `header` = 'peter'
                $queryBuilder->expr()->eq(
                    'bodytext',
                    $queryBuilder->createNamedParameter('klaus')
                ),
                $queryBuilder->expr()->eq(
                    'header',
                    $queryBuilder->createNamedParameter('peter')
                )
            )
            ->executeQuery()
            ->fetchAllAssociative();

        // ...
    }
}
