<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Model\MyEntity;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy;

class Entity extends AbstractEntity
{
    protected ChildEntity|LazyLoadingProxy $property;
}
