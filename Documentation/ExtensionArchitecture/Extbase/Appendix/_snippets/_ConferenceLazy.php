<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Model;

use TYPO3\CMS\Extbase\Attribute\ORM\Lazy;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class Conference extends AbstractEntity
{
  #[Lazy]
  protected ?Location $location = null;

  public function getLocation(): ?Location
  {
    return $this->location;
  }
}
