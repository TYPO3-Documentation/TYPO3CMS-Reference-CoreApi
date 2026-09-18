<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class Product extends AbstractEntity
{
  protected string $colorName = '';
  protected string $colorHex = '#000000';

  public function getColor(): Color
  {
    return new Color($this->colorName, $this->colorHex);
  }

  public function setColor(Color $color): void
  {
    $this->colorName = $color->name;
    $this->colorHex = $color->hex;
  }
}
