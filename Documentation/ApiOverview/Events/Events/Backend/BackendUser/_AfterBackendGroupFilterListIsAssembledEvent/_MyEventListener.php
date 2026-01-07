<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Backend\EventListener;

use TYPO3\CMS\Beuser\Event\AfterBackendGroupFilterListIsAssembledEvent;
use TYPO3\CMS\Core\Attribute\AsEventListener;

final readonly class MyEventListener
{
    #[AsEventListener]
    public function __invoke(AfterBackendGroupFilterListIsAssembledEvent $event): void
    {
        array_pop($event->backendGroups);
    }
}
