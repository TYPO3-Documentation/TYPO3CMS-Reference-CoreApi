<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Repository;

use TYPO3\CMS\Core\Database\ConnectionPool;

final class MyRepository
{
    private ConnectionPool $connectionPool;

    public function __construct(ConnectionPool $connectionPool) {
        $this->connectionPool = $connectionPool;
    }

    public function findSomething()
    {
        $queryBuilder = $this->connectionPool
            ->getQueryBuilderForTable('aTable');
    }
}
