<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Model;

use TYPO3\CMS\Extbase\Attribute\ORM\Transient;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class Conference extends AbstractEntity
{
  #[Transient]
  protected ?string $displayLabel = null;
}
