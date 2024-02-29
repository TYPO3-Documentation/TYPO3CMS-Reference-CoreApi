<?php

declare(strict_types=1);

namespace MyVendor\MyExtension;

use MyVendor\MyExtension\Queue\Message\DemoMessage;
use Symfony\Component\Messenger\MessageBusInterface;

final class MyClass
{
    public function __construct(
        private readonly MessageBusInterface $bus,
    ) {}

    public function doSomething(): void
    {
        // ...
        $this->bus->dispatch(new DemoMessage('test'));
        // ...
    }
}
