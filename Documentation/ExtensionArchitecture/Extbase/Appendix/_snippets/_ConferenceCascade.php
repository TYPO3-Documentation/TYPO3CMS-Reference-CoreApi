<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Model;

use TYPO3\CMS\Extbase\Attribute\ORM\Cascade;
use TYPO3\CMS\Extbase\Attribute\ORM\Lazy;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class Conference extends AbstractEntity
{
  #[Lazy]
  #[Cascade('remove')]
  protected ObjectStorage $comments;
}
