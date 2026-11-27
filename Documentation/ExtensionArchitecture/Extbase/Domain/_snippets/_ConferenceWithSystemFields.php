<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class Conference extends AbstractEntity
{
  protected ?int $tstamp = null;

  protected ?int $crdate = null;

  public function getTstamp(): ?int
  {
    return $this->tstamp;
  }

  public function getCrdate(): ?int
  {
    return $this->crdate;
  }
}
