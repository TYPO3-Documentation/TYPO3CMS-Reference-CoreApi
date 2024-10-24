<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Enumeration;

use TYPO3\CMS\Core\Type\Enumeration;

class State extends Enumeration
{
    public const STATE_DEFAULT = 'somestate';
    public const STATE_DISABLED = 'disabled';
}
