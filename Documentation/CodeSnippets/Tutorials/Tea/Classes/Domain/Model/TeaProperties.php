<?php

use TYPO3\CMS\Extbase\Attribute\ORM\Lazy;
use TYPO3\CMS\Extbase\Attribute\Validate;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 * This class represents a tea (flavor), e.g., "Earl Grey".
 */
class Tea extends AbstractEntity
{
  #[Validate('StringLength', options: ['maximum' => 255])]
  #[Validate('NotEmpty')]
  protected string $title = '';

  #[Validate('StringLength', options: ['maximum' => 2000])]
  protected string $description = '';

  #[Lazy]
  protected ?FileReference $image = null;
}
