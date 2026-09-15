<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Model;

use TYPO3\CMS\Extbase\Attribute\ORM\Lazy;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy;

class Conference extends AbstractEntity
{
  #[Lazy]
  protected Location|LazyLoadingProxy|null $location = null;

  public function getLocation(): ?Location
  {
    // the check is only needed to keep phpstan happy. Remove it if not needed.
    if ($this->location instanceof LazyLoadingProxy) {
      $this->location = $this->location->_loadRealInstance();
    }
    return $this->location;
  }
}
