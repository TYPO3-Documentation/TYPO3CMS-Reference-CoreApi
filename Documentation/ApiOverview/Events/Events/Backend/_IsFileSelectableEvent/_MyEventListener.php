<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Backend\EventListener;

use TYPO3\CMS\Backend\ElementBrowser\Event\IsFileSelectableEvent;
use TYPO3\CMS\Core\Attribute\AsEventListener;

#[AsEventListener(
    identifier: 'my-extension/backend/modify-file-is-selectable',
)]
final readonly class MyEventListener
{
    public function __invoke(IsFileSelectableEvent $event): void
    {
        // Deny selection of "png" images
        if ($event->getFile()->getExtension() === 'png') {
            $event->denyFileSelection();
        }
    }
}
