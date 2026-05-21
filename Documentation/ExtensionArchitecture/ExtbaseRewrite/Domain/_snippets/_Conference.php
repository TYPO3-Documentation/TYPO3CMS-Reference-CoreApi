<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Model;

use TYPO3\CMS\Extbase\Attribute\ORM\Validate;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class Conference extends AbstractEntity
{
    #[Validate(validator: 'NotEmpty')]
    protected string $title = '';

    protected string $description = '';

    protected ?\DateTimeImmutable $conferenceDate = null;

    protected bool $published = false;

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getEventDate(): ?\DateTimeImmutable
    {
        return $this->conferenceDate;
    }

    public function setEventDate(?\DateTimeImmutable $conferenceDate): void
    {
        $this->conferenceDate = $conferenceDate;
    }

    public function isPublished(): bool
    {
        return $this->published;
    }

    public function setPublished(bool $published): void
    {
        $this->published = $published;
    }
}
