<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Model;

use TYPO3\CMS\Extbase\Attribute\ORM\Transient;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class Conference extends AbstractEntity
{
  protected string $title = '';

  protected ?\DateTimeImmutable $conferenceDate = null;

  #[Transient]
  protected ?string $displayLabel = null;

  public function getDisplayLabel(): string
  {
    if ($this->displayLabel === null) {
      $year = $this->conferenceDate?->format('Y');
      $this->displayLabel = $this->title . ' (' . $year . ')';
    }
    return $this->displayLabel;
  }
}
