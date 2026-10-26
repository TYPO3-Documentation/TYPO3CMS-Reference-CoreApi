<?php

use TYPO3\CMS\Extbase\Attribute\ORM\Lazy;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy;

class Tea extends AbstractEntity
{
  #[Lazy]
  protected FileReference|LazyLoadingProxy|null $image = null;

  public function getImage(): ?FileReference
  {
    if ($this->image instanceof LazyLoadingProxy) {
      /** @var FileReference $image */
      $image = $this->image->_loadRealInstance();
      $this->image = $image;
    }

    return $this->image;
  }

  public function setImage(FileReference $image): void
  {
    $this->image = $image;
  }
}
