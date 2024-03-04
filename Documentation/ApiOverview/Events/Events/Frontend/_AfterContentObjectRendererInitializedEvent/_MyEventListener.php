<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Frontend\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Frontend\ContentObject\Event\AfterContentObjectRendererInitializedEvent;

#[AsEventListener(
    identifier: 'my-extension/my-event-listener',
)]
final readonly class MyEventListener
{
    public function __invoke(AfterContentObjectRendererInitializedEvent $event): void
    {
        $event->getContentObjectRenderer()->setCurrentVal('My current value');
    }
}
