<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Info\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Info\Controller\Event\ModifyInfoModuleContentEvent;

#[AsEventListener(
    identifier: 'my-extension/content-to-info-module',
)]
final readonly class MyEventListener
{
    public function __invoke(ModifyInfoModuleContentEvent $event): void
    {
        // Add header content for the "Localization overview" submodule,
        // if user has access to module content
        if (
            $event->hasAccess() &&
            $event->getCurrentModule()->getIdentifier() === 'web_info_translations'
        ) {
            $event->addHeaderContent('<h3>Additional header content</h3>');
        }
    }
}
