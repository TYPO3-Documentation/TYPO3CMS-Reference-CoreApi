<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Repository;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Extbase\Persistence\Repository;

class ConferenceRepository extends Repository
{
  public function __construct(
    protected readonly ConnectionPool $connectionPool,
  ) {
    parent::__construct();
  }

  public function countByYear(int $year): array
  {
    $connection = $this->connectionPool->getConnectionForTable(
      'tx_myextension_domain_model_conference',
    );
    // ... build and execute raw query
  }
}
