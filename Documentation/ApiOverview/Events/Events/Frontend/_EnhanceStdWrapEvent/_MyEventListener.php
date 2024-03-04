<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Frontend\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Frontend\ContentObject\Event\AfterStdWrapFunctionsExecutedEvent;
use TYPO3\CMS\Frontend\ContentObject\Event\AfterStdWrapFunctionsInitializedEvent;
use TYPO3\CMS\Frontend\ContentObject\Event\BeforeStdWrapFunctionsInitializedEvent;
use TYPO3\CMS\Frontend\ContentObject\Event\EnhanceStdWrapEvent;

final readonly class MyEventListener
{
    #[AsEventListener(
        identifier: 'my-extension/my-stdwrap-enhancement',
    )]
    public function __invoke(EnhanceStdWrapEvent $event): void
    {
        // listen to all events
    }

    #[AsEventListener(
        identifier: 'my-extension/my-stdwrap-before-initialized',
    )]
    public function individualListener(BeforeStdWrapFunctionsInitializedEvent $event): void
    {
        // listen on BeforeStdWrapFunctionsInitializedEvent only
    }

    #[AsEventListener(
        identifier: 'my-extension/my-stdwrap-after-initialized-executed',
    )]
    public function listenOnMultipleEvents(
        AfterStdWrapFunctionsInitializedEvent|AfterStdWrapFunctionsExecutedEvent $event,
    ): void {
        // Union type to listen to different events
    }
}
