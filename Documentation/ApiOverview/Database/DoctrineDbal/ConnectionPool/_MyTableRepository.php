<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Repository;

use TYPO3\CMS\Core\Database\ConnectionPool;

final class MyTableRepository
{
    private const TABLE_NAME = 'tx_myextension_domain_model_mytable';

    public function __construct(
        private readonly ConnectionPool $connectionPool,
    ) {}

    public function findSomething()
    {
        // Get a query builder for a table
        $queryBuilder = $this->connectionPool
            ->getQueryBuilderForTable(self::TABLE_NAME);

        // Or get a connection for a table
        $connection = $this->connectionPool
            ->getConnectionForTable(self::TABLE_NAME);
    }
}
