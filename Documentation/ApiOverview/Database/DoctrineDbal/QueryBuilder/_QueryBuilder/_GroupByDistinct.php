<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Repository;

use TYPO3\CMS\Core\Database\Query\QueryBuilder;

final class MyDbalRepository
{
  public function selectDistinctFields(QueryBuilder $queryBuilder): void
  {
    // Equivalent to:
    // SELECT DISTINCT some_field, another_field FROM my_table

    $queryBuilder
        ->select('some_field', 'another_field')
        ->from('my_table')
        ->groupBy('some_field')
        ->addGroupBy('another_field');
  }
}
