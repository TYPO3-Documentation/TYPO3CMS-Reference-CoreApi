<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Frontend\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Frontend\Event\AfterCachedPageIsPersistedEvent;

#[AsEventListener(
    identifier: 'my-extension/content-modifier',
)]
final readonly class MyEventListener
{
    public function __invoke(AfterCachedPageIsPersistedEvent $event): void
    {
        // generate static file cache
    }
}
