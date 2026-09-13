<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Repository;

use TYPO3\CMS\Core\Database\ConnectionPool;

final readonly class MyDbalRepository
{
  public function __construct(
    private ConnectionPool $connectionPool,
  ) {}

  public function findWhereHeaderEqualsBodytext(): void
  {
    // SELECT `uid` FROM `tt_content` WHERE (`header` = `bodytext`)
    // Return list of rows where header and bodytext values are identical
    $queryBuilder = $this->connectionPool
        ->getQueryBuilderForTable('tt_content');
    $queryBuilder
        ->select('uid')
        ->from('tt_content')
        ->where(
          $queryBuilder->expr()->eq(
            'header',
            $queryBuilder->quoteIdentifier('bodytext'),
          ),
        );
  }
}
