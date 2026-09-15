<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Model;

use TYPO3\CMS\Extbase\Attribute\Validate;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class Conference extends AbstractEntity
{
  #[Validate(validator: 'NotEmpty')]
  #[Validate(
    validator: 'StringLength',
    options: ['minimum' => 3, 'maximum' => 50],
  )]
  protected string $title = '';
}
