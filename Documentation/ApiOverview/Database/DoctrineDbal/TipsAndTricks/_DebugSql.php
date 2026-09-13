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

  public function findByBodytext(): Result
  {
    $queryBuilder = $this->connectionPool
        ->getQueryBuilderForTable('tt_content');
    $queryBuilder
        ->select('uid')
        ->from('tt_content')
        ->where(
          $queryBuilder->expr()->eq(
            'bodytext',
            $queryBuilder->createNamedParameter('lorem'),
          ),
        );

    debug($queryBuilder->getSQL());

    return $queryBuilder->executeQuery();
  }
}
