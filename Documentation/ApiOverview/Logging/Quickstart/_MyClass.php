<?php

declare(strict_types=1);

namespace MyVendor\MyExtension;

use Psr\Log\LoggerInterface;

class MyClass
{
    public function __construct(
        private readonly LoggerInterface $logger,
    ) {}
}
