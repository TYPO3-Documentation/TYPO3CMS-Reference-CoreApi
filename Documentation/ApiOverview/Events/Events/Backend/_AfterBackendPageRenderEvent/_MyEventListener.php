<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Backend\EventListener;

use TYPO3\CMS\Backend\Controller\Event\AfterBackendPageRenderEvent;
use TYPO3\CMS\Core\Attribute\AsEventListener;

final class MyEventListener
{
    #[AsEventListener(
        identifier: 'my-extension/backend/after-backend-page-render',
    )]
    public function __invoke(AfterBackendPageRenderEvent $event): void
    {
        $content = $event->getContent() . ' I was here';
        $event->setContent($content);
    }
}
