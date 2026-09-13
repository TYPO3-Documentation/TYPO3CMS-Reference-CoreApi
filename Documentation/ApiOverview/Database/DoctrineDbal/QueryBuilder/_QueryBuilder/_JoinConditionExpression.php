<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Repository;

use TYPO3\CMS\Core\Database\Query\QueryBuilder;

final class MyDbalRepository
{
  public function joinWithMultipleConditions(QueryBuilder $queryBuilder): void
  {
    $joinConditionExpression = $queryBuilder->expr()->and(
      $queryBuilder->expr()->eq(
        'tt_content_orig.sys_language_uid',
        $queryBuilder->quoteIdentifier('sys_language.uid'),
      ),
      $queryBuilder->expr()->eq(
        'tt_content_orig.sys_language_uid',
        $queryBuilder->quoteIdentifier('sys_language.uid'),
      ),
    );
    $queryBuilder->leftJoin(
      'tt_content_orig',
      'sys_language',
      'sys_language',
      (string)$joinConditionExpression,
    );
  }
}
