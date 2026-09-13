<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Repository;

use Doctrine\DBAL\Result;
use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;

final readonly class MyDbalRepository
{
  public function __construct(
    private ConnectionPool $connectionPool,
  ) {}

  public function findWithUidGreaterThan(): Result
  {
    // SELECT `uid` FROM `tt_content` WHERE (`uid` > 42)
    $queryBuilder = $this->connectionPool
        ->getQueryBuilderForTable('tt_content');
    return $queryBuilder
        ->select('uid')
        ->from('tt_content')
        ->where(
          $queryBuilder->expr()->gt(
            'uid',
            $queryBuilder->createNamedParameter(
              42,
              Connection::PARAM_INT,
            ),
          ),
        )
        ->executeQuery();
  }
}
