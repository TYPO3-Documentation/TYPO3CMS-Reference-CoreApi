<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Frontend\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Frontend\Event\ModifyCacheLifetimeForPageEvent;

#[AsEventListener(
    identifier: 'my-extension/cache-timeout',
)]
final readonly class MyEventListener
{
    public function __invoke(ModifyCacheLifetimeForPageEvent $event): void
    {
        // Only cache all pages for 30 seconds when in development context
        if (Environment::getContext()->isDevelopment()) {
            $event->setCacheLifetime(30);
        }
    }
}
