<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Repository;

use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;

final class MyTableRepository
{
    private const TABLE_NAME = 'tt_content';

    public function __construct(
        private readonly ConnectionPool $connectionPool,
    ) {}

    public function findSomething()
    {
        $queryBuilder = $this->connectionPool->getQueryBuilderForTable(self::TABLE_NAME);

        $rows = $queryBuilder
            ->select('uid', 'header', 'bodytext')
            ->from(self::TABLE_NAME)
            ->where(
                // `bodytext` = 'lorem' AND `header` = 'dolor'
                $queryBuilder->expr()->eq(
                    'bodytext',
                    $queryBuilder->createNamedParameter('lorem', Connection::PARAM_STR),
                ),
                $queryBuilder->expr()->eq(
                    'header',
                    $queryBuilder->createNamedParameter('dolor', Connection::PARAM_STR),
                ),
            )
            ->executeQuery()
            ->fetchAllAssociative();

        // ...
    }
}
