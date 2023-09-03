<?php

namespace Vendor\MyPackage\Core\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Core\Imaging\Event\ModifyRecordOverlayIconIdentifierEvent;

final class ModifyRecordOverlayIconIdentifierEventListener
{
    #[AsEventListener('my-package/core/modify-record-overlay-icon-identifier')]
    public function __invoke(ModifyRecordOverlayIconIdentifierEvent $event): void
    {
        $event->setOverlayIconIdentifier('my-overlay-icon-identifier');
    }
}
