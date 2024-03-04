<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Backend\EventListener;

use TYPO3\CMS\Backend\Controller\Event\ModifyLinkHandlersEvent;
use TYPO3\CMS\Core\Attribute\AsEventListener;

#[AsEventListener(
    identifier: 'my-extension/backend/link-handlers',
)]
final readonly class MyEventListener
{
    public function __invoke(ModifyLinkHandlersEvent $event): void
    {
        $handler = $event->getLinkHandler('url.');
        $handler['label'] = 'My custom label';
        $event->setLinkHandler('url.', $handler);
    }
}
