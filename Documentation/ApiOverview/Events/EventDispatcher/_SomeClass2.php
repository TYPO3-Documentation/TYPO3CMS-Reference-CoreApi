<?php

declare(strict_types=1);

namespace MyVendor\MyExtension;

use MyVendor\MyExtension\Event\DoingThisAndThatEvent;
use Psr\EventDispatcher\EventDispatcherInterface;

final class SomeClass
{
    public function __construct(
        private readonly EventDispatcherInterface $eventDispatcher,
    ) {}

    public function doSomething(): void
    {
        // ..

        /** @var DoingThisAndThatEvent $event */
        $event = $this->eventDispatcher->dispatch(
            new DoingThisAndThatEvent('foo', 2)
        );
        $someChangedValue = $event->getMutableProperty();

        // ...
    }
}
