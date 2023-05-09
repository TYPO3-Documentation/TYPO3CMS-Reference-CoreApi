<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Resource\EventListener;

use TYPO3\CMS\Core\Resource\Event\AfterFileCommandProcessedEvent;

final class MyEventListener
{
    public function __invoke(AfterFileCommandProcessedEvent $event): void
    {
        // Do magic here
    }
}
