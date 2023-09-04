<?php

declare(strict_types=1);

namespace Vendor\MyExtension\Imaging\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Core\Imaging\Event\ModifyRecordOverlayIconIdentifierEvent;

final class ModifyRecordOverlayIconIdentifierEventListener
{
    #[AsEventListener('my-extension/imaging/modify-record-overlay-icon-identifier')]
    public function __invoke(ModifyRecordOverlayIconIdentifierEvent $event): void
    {
        $event->setOverlayIconIdentifier('my-overlay-icon-identifier');
    }
}
