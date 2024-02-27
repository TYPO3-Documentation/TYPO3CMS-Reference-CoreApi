<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Model\Enum;

enum Level: string
{
    case INFO = 'info';
    case ERROR = 'error';
}
