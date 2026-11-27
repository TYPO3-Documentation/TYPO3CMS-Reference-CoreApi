<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Model;

use TYPO3\CMS\Extbase\Attribute\Validate;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class Conference extends AbstractEntity
{
  /**
   * @var list<string>
   */
  #[Validate('Collection', options: ['elementValidator' => 'EmailAddress'])]
  protected array $contactEmails = [];
}
