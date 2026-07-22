<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Model;

use MyVendor\MyExtension\Enum\Status;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class Paper extends AbstractEntity
{
    protected Status $status = Status::DRAFT;

    // ... more properties
}
