<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Repository;

use TYPO3\CMS\Core\Database\ConnectionPool;

final class MyRepository
{
    public function __construct(
        private readonly ConnectionPool $connectionPool,
    ) {}

    public function findSomething()
    {
        $queryBuilder = $this->connectionPool
            ->getQueryBuilderForTable('aTable');
    }
}
