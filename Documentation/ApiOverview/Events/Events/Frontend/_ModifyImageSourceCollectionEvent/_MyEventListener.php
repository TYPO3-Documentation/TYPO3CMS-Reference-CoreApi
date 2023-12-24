<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Frontend\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Frontend\ContentObject\Event\ModifyImageSourceCollectionEvent;

#[AsEventListener(
    identifier: 'my-extension/my-event-listener'
)]
final class MyEventListener
{
    public function __invoke(ModifyImageSourceCollectionEvent $event): void
    {
        $event->setSourceCollection(
            '<source src="bar-file.jpg" media="(max-device-width: 600px)">'
        );
    }
}
