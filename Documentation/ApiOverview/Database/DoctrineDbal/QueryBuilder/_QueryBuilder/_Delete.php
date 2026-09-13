<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Repository;

use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;

final readonly class MyDbalRepository
{
  public function __construct(
    private ConnectionPool $connectionPool,
  ) {}

  public function deleteByBodytext(): int
  {
    // DELETE FROM `tt_content` WHERE `bodytext` = 'lorem'
    $queryBuilder = $this->connectionPool
        ->getQueryBuilderForTable('tt_content');
    return $queryBuilder
        ->delete('tt_content')
        ->where(
          $queryBuilder->expr()->eq(
            'bodytext',
            $queryBuilder->createNamedParameter(
              'lorem',
              Connection::PARAM_STR,
            ),
          ),
        )
        ->executeStatement();
  }
}
