<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Model\MyEntity;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class Entity extends AbstractEntity
{
    private string|int $property;
}
