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

    public function findByPage(): void
    {
        // Fetch all records from tt_content on page 42
        $queryBuilder = $this->connectionPool
            ->getQueryBuilderForTable('tt_content');
        $result = $queryBuilder
            ->select('uid', 'bodytext')
            ->from('tt_content')
            ->where(
                $queryBuilder->expr()->eq(
                    'pid',
                    $queryBuilder->createNamedParameter(
                        42,
                        Connection::PARAM_INT,
                    ),
                ),
            )
            ->executeQuery();

        while ($row = $result->fetchAssociative()) {
            // Do something useful with that single $row
        }
    }
}
