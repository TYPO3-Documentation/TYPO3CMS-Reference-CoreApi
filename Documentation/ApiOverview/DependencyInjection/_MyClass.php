<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Controller;

use Psr\Clock\ClockInterface;

final class MyClass
{
    public function __construct(
        private readonly ClockInterface $clock,
    ) {}

    // ...
}
