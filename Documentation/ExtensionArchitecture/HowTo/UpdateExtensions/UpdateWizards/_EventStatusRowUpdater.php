<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Upgrades\RowUpdater;

use TYPO3\CMS\Core\Attribute\AsRowUpdater;
use TYPO3\CMS\Core\Upgrades\RowUpdater\RowUpdaterInterface;

#[AsRowUpdater('myExtension_eventStatus')]
final class EventStatusRowUpdater implements RowUpdaterInterface
{
  private const TABLE = 'tx_myextension_domain_model_event';

  public function getTitle(): string
  {
    return 'Migrate the status "archived" of events to "closed"';
  }

  public function hasPotentialUpdateForTable(string $tableName): bool
  {
    return $tableName === self::TABLE;
  }

  public function updateTableRow(string $tableName, array $row): array
  {
    if ($row['status'] === 'archived') {
      $row['status'] = 'closed';
    }
    return $row;
  }
}
