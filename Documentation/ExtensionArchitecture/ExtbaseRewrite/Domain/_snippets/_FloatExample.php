<?php

declare(strict_types=1);

namespace Vendor\MyExtension\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class FloatExample extends AbstractEntity
{
    public float $price = 0.0;

    public ?float $rating = null;
}
