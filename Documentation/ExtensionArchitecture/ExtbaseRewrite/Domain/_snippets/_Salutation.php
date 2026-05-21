<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Model\Enum;

enum Salutation: string
{
    case None = '';
    case Mr = 'mr';
    case Ms = 'ms';
    case Mx = 'mx';
}
