<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Backend\EventListener;

use TYPO3\CMS\Backend\Form\Event\ModifyInlineElementControlsEvent;
use TYPO3\CMS\Backend\Form\Event\ModifyInlineElementEnabledControlsEvent;
use TYPO3\CMS\Core\Imaging\Icon;
use TYPO3\CMS\Core\Imaging\IconFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;

final class MyEventListener
{
    public function modifyEnabledControls(ModifyInlineElementEnabledControlsEvent $event): void
    {
        // Enable a control depending on the foreign table
        if ($event->getForeignTable() === 'sys_file_reference' && $event->isControlEnabled('sort')) {
            $event->enableControl('sort');
        }
    }

    public function modifyControls(ModifyInlineElementControlsEvent $event): void
    {
        // Add a custom control depending on the parent table
        if ($event->getElementData()['inlineParentTableName'] === 'tt_content') {
            $iconFactory = GeneralUtility::makeInstance(IconFactory::class);
            $event->setControl(
                'tx_my_control',
                '<a href="/some/url" class="btn btn-default t3js-modal-trigger">'
                . $iconFactory->getIcon('my-icon-identifier', Icon::SIZE_SMALL)->render()
                . '</a>'
            );
        }
    }
}
