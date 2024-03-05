<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Repository;

use TYPO3\CMS\Core\Database\ConnectionPool;

final class MyTableRepository
{
    private const TABLE_NAME = 'tx_myextension_domain_model_mytable';

    private ConnectionPool $connectionPool;

    public function __construct(ConnectionPool $connectionPool) {
        $this->connectionPool = $connectionPool;
    }

    public function findSomething()
    {
        // Get a query builder for a table
        $queryBuilder = $this->connectionPool
            ->getQueryBuilderForTable(self::TABLE_NAME);
    }
}
