<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Model\MyEntity;

use TYPO3\CMS\Extbase\Attribute\ORM\Lazy;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class Entity extends AbstractEntity
{
    #[Lazy]
    protected ObjectStorage $property;

    public function initializeObject(): void
    {
        $this->property = new ObjectStorage();
    }
}
