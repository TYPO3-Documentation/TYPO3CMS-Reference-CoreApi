<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Backend\EventListener;

use TYPO3\CMS\Backend\Controller\Event\ModifyPageLayoutContentEvent;
use TYPO3\CMS\Core\Attribute\AsEventListener;

#[AsEventListener(
    identifier: 'my-extension/backend/modify-page-module-content',
)]
final readonly class MyEventListener
{
    public function __invoke(ModifyPageLayoutContentEvent $event): void
    {
        // Get the current page ID
        $id = (int)($event->getRequest()->getQueryParams()['id'] ?? 0);

        $event->addHeaderContent('Additional header content');

        $event->setFooterContent('Overwrite footer content');
    }
}
