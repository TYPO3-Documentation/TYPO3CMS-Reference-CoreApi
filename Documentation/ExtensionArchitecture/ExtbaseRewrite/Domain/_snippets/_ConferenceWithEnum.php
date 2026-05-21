<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Model;

use MyVendor\MyExtension\Domain\Model\Enum\Salutation;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class Speaker extends AbstractEntity
{
    protected string $name = '';

    protected Salutation $salutation = Salutation::None;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getSalutation(): Salutation
    {
        return $this->salutation;
    }

    public function setSalutation(Salutation $salutation): void
    {
        $this->salutation = $salutation;
    }
}
