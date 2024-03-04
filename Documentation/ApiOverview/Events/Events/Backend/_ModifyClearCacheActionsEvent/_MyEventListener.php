<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Backend\EventListener;

use TYPO3\CMS\Backend\Backend\Event\ModifyClearCacheActionsEvent;
use TYPO3\CMS\Core\Attribute\AsEventListener;

#[AsEventListener(
    identifier: 'my-extension/toolbar/my-event-listener',
)]
final readonly class MyEventListener
{
    public function __invoke(ModifyClearCacheActionsEvent $event): void
    {
        // do magic here
    }
}
