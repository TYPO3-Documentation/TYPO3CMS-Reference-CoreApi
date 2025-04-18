<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Model\MyEntity;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class Entity extends AbstractEntity
{
    /**
     * @var ObjectStorage<ChildEntity>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     */
    private ObjectStorage $property;
}
