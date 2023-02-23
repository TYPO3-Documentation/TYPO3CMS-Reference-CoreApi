<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Backend\EventListener;

use TYPO3\CMS\Backend\Backend\Event\ModifyClearCacheActionsEvent;

final class MyEventListener
{
    public function __invoke(ModifyClearCacheActionsEvent $event): void
    {
        // do magic here
    }
}
