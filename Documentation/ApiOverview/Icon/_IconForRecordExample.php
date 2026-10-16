<?php

declare(strict_types=1);

namespace MyVendor\MyExtension;

use TYPO3\CMS\Core\Domain\RecordInterface;
use TYPO3\CMS\Core\Imaging\Icon;
use TYPO3\CMS\Core\Imaging\IconFactory;
use TYPO3\CMS\Core\Imaging\IconSize;

final class MyRecordIconClass
{
  public function __construct(
    private readonly IconFactory $iconFactory,
  ) {}

  public function getIconForRow(array $row): Icon
  {
    // A plain database row needs its table name
    return $this->iconFactory->getIconForRecord(
      'tt_content',
      $row,
      IconSize::SMALL,
    );
  }

  public function getIconForRecord(RecordInterface $record): Icon
  {
    // A record object already knows its table
    return $this->iconFactory->getIconForRecordObject(
      $record,
      IconSize::SMALL,
    );
  }
}
