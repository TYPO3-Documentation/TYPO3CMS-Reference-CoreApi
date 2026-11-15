<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Model;

use TYPO3\CMS\Extbase\Attribute\IgnoreValidation;
use TYPO3\CMS\Extbase\Attribute\ORM\Transient;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class Conference extends AbstractEntity
{
  // TYPO3 v15 evaluates #[IgnoreValidation], v13.4 and v14 #[Transient]
  #[IgnoreValidation]
  #[Transient]
  protected ?Organizer $organizer = null;
}
