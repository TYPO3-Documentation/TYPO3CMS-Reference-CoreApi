<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Resource\EventListener;

use TYPO3\CMS\Core\Resource\OnlineMedia\Event\AfterVideoPreviewFetchedEvent;

final class MyEventListener
{
    public function __invoke(AfterVideoPreviewFetchedEvent $event): void
    {
        $event->setPreviewImageFilename(
            '/var/www/html/typo3temp/assets/online_media/new-preview-image.jpg'
        );
    }
}
