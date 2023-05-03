<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Frontend\EventListener;

use TYPO3\CMS\Frontend\Event\AfterCachedPageIsPersistedEvent;

final class MyEventListener
{
    public function __invoke(AfterCachedPageIsPersistedEvent $event): void
    {
        // generate static file cache
    }
}
