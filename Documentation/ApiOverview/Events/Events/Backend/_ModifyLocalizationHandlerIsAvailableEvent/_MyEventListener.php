<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\EventListener;

use TYPO3\CMS\Backend\Localization\Event\ModifyLocalizationHandlerIsAvailableEvent;
use TYPO3\CMS\Backend\Localization\LocalizationMode;
use TYPO3\CMS\Backend\Localization\ManualLocalizationHandler;
use TYPO3\CMS\Core\Attribute\AsEventListener;

final class DisableManualLocalizationHandlerForCustomTableEventListener
{
    #[AsEventListener(identifier: 'myextension/disable-manual-localization-handler-custom-table')]
    public function __invoke(
        ModifyLocalizationHandlerIsAvailableEvent $event,
    ): void {
        if ($event->identifier !== 'manual') {
            // Return early if not ManualLocalizationHandler
            return;
        }
        if ($event->className !== ManualLocalizationHandler::class) {
            // Return early in case manual identifier is provided but
            // customized (xlassed) class given. Just for the sake of
            // an example for that property.
        }
        if ($event->instructions->mode !== LocalizationMode::TRANSLATE) {
            // Return early in case not handling translation
            // (localization) mode.
            return;
        }

        if ($event->instructions->mainRecordType === 'my_custom_table') {
            // Disallow translation/localization for 'my_custom_table'
            // in general with the default core handler.
            $event->isAvailable = false;
        }
    }
}
