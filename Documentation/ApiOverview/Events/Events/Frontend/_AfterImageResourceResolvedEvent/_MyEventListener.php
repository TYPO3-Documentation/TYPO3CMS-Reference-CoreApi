<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Frontend\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Frontend\ContentObject\Event\AfterImageResourceResolvedEvent;

#[AsEventListener(
    identifier: 'my-extension/my-event-listener'
)]
final class MyEventListener
{
    public function __invoke(AfterImageResourceResolvedEvent $event): void
    {
        $modifiedImageResource = $event
            ->getImageResource()
            ->withWidth(123);

        $event->setImageResource($modifiedImageResource);
    }
}
