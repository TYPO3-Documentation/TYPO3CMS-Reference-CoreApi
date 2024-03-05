<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Frontend\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Frontend\ContentObject\Event\BeforeStdWrapContentStoredInCacheEvent;

#[AsEventListener(
    identifier: 'my-extension/before-stdwrap-content-stored-in-cache',
)]
final readonly class MyEventListener
{
    public function __invoke(BeforeStdWrapContentStoredInCacheEvent $event): void
    {
        if (in_array('foo', $event->getTags(), true)) {
            $event->setContent('modified-content');
        }
    }
}
