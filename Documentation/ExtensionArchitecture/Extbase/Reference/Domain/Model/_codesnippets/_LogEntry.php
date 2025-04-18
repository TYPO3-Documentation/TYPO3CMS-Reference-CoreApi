<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class LogEntry extends AbstractEntity
{
    protected Enum\Level $level;

    // ... more properties
}
