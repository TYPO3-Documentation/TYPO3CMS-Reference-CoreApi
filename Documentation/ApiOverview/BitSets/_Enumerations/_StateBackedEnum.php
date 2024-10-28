<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Enumeration;

enum State: string
{
    case STATE_DEFAULT = 'somestate';
    case STATE_DISABLED = 'disabled';
}
