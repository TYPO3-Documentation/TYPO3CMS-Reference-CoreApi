<?php

use TYPO3\CMS\Extbase\Attribute\ORM\Lazy;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class Tea extends AbstractEntity
{
  #[Lazy]
  protected ?FileReference $image = null;

  public function getImage(): ?FileReference
  {
    return $this->image;
  }

  public function setImage(FileReference $image): void
  {
    $this->image = $image;
  }
}
