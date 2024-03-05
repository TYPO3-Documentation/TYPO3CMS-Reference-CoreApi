<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Backend\EventListener;

use TYPO3\CMS\Backend\Routing\Event\AfterPagePreviewUriGeneratedEvent;
use TYPO3\CMS\Core\Attribute\AsEventListener;

#[AsEventListener(
    identifier: 'my-extension/backend/modify-preview-uri',
)]
final readonly class MyEventListener
{
    public function __invoke(AfterPagePreviewUriGeneratedEvent $event): void
    {
        // Add custom fragment to built preview URI
        $uri = $event->getPreviewUri();
        $uri = $uri->withFragment('#customFragment');
        $event->setPreviewUri($uri);
    }
}
