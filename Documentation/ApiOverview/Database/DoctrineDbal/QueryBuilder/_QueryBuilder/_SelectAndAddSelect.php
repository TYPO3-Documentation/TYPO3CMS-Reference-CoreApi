<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Repository;

use TYPO3\CMS\Core\Database\Query\QueryBuilder;

final class MyDbalRepository
{
  public function selectFields(
    QueryBuilder $queryBuilder,
    array $defaultList,
    array $additionalFields,
    bool $needAdditionalFields,
  ): void {
    $queryBuilder->select(...$defaultList);
    if ($needAdditionalFields) {
      $queryBuilder->addSelect(...$additionalFields);
    }
  }
}
