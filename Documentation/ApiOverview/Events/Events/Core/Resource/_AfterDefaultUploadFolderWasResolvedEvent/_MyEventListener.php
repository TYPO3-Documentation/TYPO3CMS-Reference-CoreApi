<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Resource\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Core\Resource\Event\AfterDefaultUploadFolderWasResolvedEvent;

#[AsEventListener(
    identifier: 'my-extension/after-default-upload-folder-was-resolved',
)]
final readonly class MyEventListener
{
    public function __invoke(AfterDefaultUploadFolderWasResolvedEvent $event): void
    {
        $event->setUploadFolder($event->getUploadFolder()->getStorage()->getFolder('/'));
    }
}
