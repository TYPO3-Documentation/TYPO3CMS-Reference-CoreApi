<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Repository;

use TYPO3\CMS\Core\Database\Query\QueryBuilder;

final class MyDbalRepository
{
  public function selectFrom(QueryBuilder $queryBuilder): void
  {
    // FROM `myTable`
    $queryBuilder->from('myTable');

    // FROM `myTable` AS `anAlias`
    $queryBuilder->from('myTable', 'anAlias');
  }
}
