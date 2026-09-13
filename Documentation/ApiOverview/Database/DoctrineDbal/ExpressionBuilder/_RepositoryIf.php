<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Repository;

use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;

final class MyTableDbalRepository
{
  private const TABLE_NAME = 'pages';

  public function __construct(
    private readonly ConnectionPool $connectionPool,
  ) {}

  public function demonstrateIf(): void
  {
    $queryBuilder = $this->connectionPool
        ->getQueryBuilderForTable(self::TABLE_NAME);
    $queryBuilder
        ->selectLiteral(
          $queryBuilder->expr()->if(
            $queryBuilder->expr()->eq(
              'hidden',
              $queryBuilder->createNamedParameter(
                0,
                Connection::PARAM_INT,
              ),
            ),
            $queryBuilder->quote('page-is-visible'),
            $queryBuilder->quote('page-is-not-visible'),
            'result_field_name',
          ),
        )
        ->from(self::TABLE_NAME);
  }
}
