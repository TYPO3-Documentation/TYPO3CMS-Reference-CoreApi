<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Model;

use Symfony\Component\Validator\Constraints as Assert;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class Conference extends AbstractEntity
{
  #[Assert\NotBlank]
  #[Assert\Length(max: 255)]
  protected string $title = '';

  #[Assert\Url(
    message: 'LLL:EXT:my_extension/Resources/Private/Language/errors.xlf:url',
  )]
  protected string $website = '';
}
