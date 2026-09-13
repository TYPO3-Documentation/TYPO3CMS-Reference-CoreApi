<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Repository;

use TYPO3\CMS\Core\Database\ConnectionPool;

final readonly class MyDbalRepository
{
  public function __construct(
    private ConnectionPool $connectionPool,
  ) {}

  public function insertContentElement(): int
  {
    // INSERT INTO `tt_content` (`bodytext`, `header`)
    //     VALUES ('lorem', 'dolor')
    $queryBuilder = $this->connectionPool
        ->getQueryBuilderForTable('tt_content');
    return $queryBuilder
        ->insert('tt_content')
        ->values([
          'bodytext' => 'lorem',
          'header' => 'dolor',
        ])
        ->executeStatement();
  }
}
