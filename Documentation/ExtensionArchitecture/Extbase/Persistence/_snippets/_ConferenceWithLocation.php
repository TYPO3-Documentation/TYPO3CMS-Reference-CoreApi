<?php

namespace MyVendor\MyExtension\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class Conference extends AbstractEntity
{
  protected ?Location $location = null;

  protected function getLocation(): ?Location
  {
    return $this->location;
  }

}
