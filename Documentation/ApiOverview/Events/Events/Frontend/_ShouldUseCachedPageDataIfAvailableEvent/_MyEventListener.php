<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Frontend\EventListener;

use TYPO3\CMS\Frontend\Event\ShouldUseCachedPageDataIfAvailableEvent;

final class MyEventListener
{
    public function __invoke(ShouldUseCachedPageDataIfAvailableEvent $event): void
    {
        if (!($event->getRequest()->getServerParams()['X-SolR-API'] ?? null)) {
            return;
        }
        $event->setShouldUseCachedPageData(false);
    }
}
