<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Resource\EventListener;

use TYPO3\CMS\Core\Resource\Event\AfterDefaultUploadFolderWasResolvedEvent;

final class AfterDefaultUploadFolderWasResolvedEventListener
{
    public function __invoke(AfterDefaultUploadFolderWasResolvedEvent $event): void
    {
        $event->setUploadFolder($event->getUploadFolder()->getStorage()->getFolder('/'));
    }
}
