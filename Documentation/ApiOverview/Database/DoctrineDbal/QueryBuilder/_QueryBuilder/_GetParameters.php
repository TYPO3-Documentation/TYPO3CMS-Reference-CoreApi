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

  public function findAllLanguages(): Result
  {
    $queryBuilder = $this->connectionPool
        ->getQueryBuilderForTable('sys_language');
    $queryBuilder
        ->select('*')
        ->from('sys_language');
    debug($queryBuilder->getParameters());
    return $queryBuilder->executeQuery();
  }
}
