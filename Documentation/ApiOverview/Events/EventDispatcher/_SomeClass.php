<?php

declare(strict_types=1);

namespace MyVendor\MyExtension;

use Psr\EventDispatcher\EventDispatcherInterface;

final class SomeClass
{
    public function __construct(
        private readonly EventDispatcherInterface $eventDispatcher,
    ) {}
}
