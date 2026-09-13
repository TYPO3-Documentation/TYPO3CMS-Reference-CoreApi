<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Repository;

use TYPO3\CMS\Core\Database\ConnectionPool;

final readonly class MyDbalRepository
{
  public function __construct(
    private ConnectionPool $connectionPool,
  ) {}

  public function findAllLanguagesOrderedBySorting(): array
  {
    // SELECT * FROM `sys_language` ORDER BY `sorting` ASC
    $queryBuilder = $this->connectionPool
        ->getQueryBuilderForTable('sys_language');
    $queryBuilder->getRestrictions()->removeAll();
    return $queryBuilder
        ->select('*')
        ->from('sys_language')
        ->orderBy('sorting')
        ->executeQuery()
        ->fetchAllAssociative();
  }
}
