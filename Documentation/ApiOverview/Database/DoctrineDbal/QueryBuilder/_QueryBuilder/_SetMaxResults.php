<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Repository;

use Doctrine\DBAL\Result;
use TYPO3\CMS\Core\Database\ConnectionPool;

final readonly class MyDbalRepository
{
    public function __construct(
        private ConnectionPool $connectionPool,
    ) {}

    public function findLanguagesPaginated(): Result
    {
        // SELECT * FROM `sys_language` LIMIT 2 OFFSET 4
        $queryBuilder = $this->connectionPool
            ->getQueryBuilderForTable('sys_language');
        return $queryBuilder
            ->select('*')
            ->from('sys_language')
            ->setMaxResults(2)
            ->setFirstResult(4)
            ->executeQuery();
    }
}
