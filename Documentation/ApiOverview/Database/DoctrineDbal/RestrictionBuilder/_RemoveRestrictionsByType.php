<?php

declare(strict_types=1);

namespace MyVendor\MyExtension;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\Restriction\EndTimeRestriction;
use TYPO3\CMS\Core\Database\Query\Restriction\StartTimeRestriction;

final readonly class MyClass
{
  public function __construct(
    private ConnectionPool $connectionPool,
  ) {}

  public function removeTimeRestrictions(): void
  {
    // Remove starttime and endtime, but keep hidden and deleted
    $queryBuilder = $this->connectionPool
        ->getQueryBuilderForTable('tt_content');
    $queryBuilder
        ->getRestrictions()
        ->removeByType(StartTimeRestriction::class)
        ->removeByType(EndTimeRestriction::class);
  }
}
