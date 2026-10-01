<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Model;

use TYPO3\CMS\Extbase\Attribute\Validate;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class BoolExample extends AbstractEntity
{
  public bool $wantsNewsletter = false;

  #[Validate(
    validator: 'Boolean',
    options: ['is' => true],
  )]
  public bool $acceptedPrivacyPolicy = false;
}
