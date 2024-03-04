<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Resource\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Core\Resource\OnlineMedia\Event\AfterVideoPreviewFetchedEvent;

#[AsEventListener(
    identifier: 'my-extension/after-video-preview-fetched',
)]
final readonly class MyEventListener
{
    public function __invoke(AfterVideoPreviewFetchedEvent $event): void
    {
        $event->setPreviewImageFilename(
            '/var/www/html/typo3temp/assets/online_media/new-preview-image.jpg',
        );
    }
}
