<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class DateExample extends AbstractEntity
{
    /**
     * A datetime stored in an integer field
     */
    public ?\DateTime $datetimeInt = null;

    /**
     * A datetime stored in a datetime field
     */
    public ?\DateTime $datetimeDatetime = null;
}
