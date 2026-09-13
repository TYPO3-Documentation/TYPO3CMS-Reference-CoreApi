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

    public function countByPage(): int
    {
        // Get the number of tt_content records on pid 42
        $queryBuilder = $this->connectionPool
            ->getQueryBuilderForTable('tt_content');
        return (int)$queryBuilder
            ->count('uid')
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
            ->executeQuery()
            ->fetchOne();
    }
}
