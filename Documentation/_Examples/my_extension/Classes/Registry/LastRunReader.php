<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Registry;

use TYPO3\CMS\Core\Registry;

final class LastRunReader
{
  public function __construct(
    private readonly Registry $registry,
  ) {}

  /**
   * @return array{startTime: int, endTime: int}|null
   */
  public function getLastRun(): ?array
  {
    return $this->registry->get(
      'tx_myextension',
      'lastRun',
    );
  }
}
