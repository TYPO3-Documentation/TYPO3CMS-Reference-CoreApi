<?php

declare(strict_types=1);

namespace Vendor\MyExtension\Imaging\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Core\Imaging\Event\ModifyRecordOverlayIconIdentifierEvent;

#[AsEventListener(
    identifier: 'my-extension/imaging/modify-record-overlay-icon-identifier',
)]
final readonly class MyEventListener
{
    public function __invoke(ModifyRecordOverlayIconIdentifierEvent $event): void
    {
        if ($event->getTable() === 'tx_myextension_domain_model_mytable') {
            $event->setOverlayIconIdentifier('my-overlay-icon-identifier');
        }
    }
}
