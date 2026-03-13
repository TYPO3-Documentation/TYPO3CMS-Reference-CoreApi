<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Backend\EventListener;

use TYPO3\CMS\Backend\Controller\Event\BeforeBackendPageRenderEvent;
use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Core\Page\JavaScriptModuleInstruction;

#[AsEventListener(
    identifier: 'my-extension/backend/before-backend-page-render',
)]
final readonly class MyEventListener
{
    public function __invoke(BeforeBackendPageRenderEvent $event): void
    {
        $event->javaScriptRenderer->addJavaScriptModuleInstruction(
            JavaScriptModuleInstruction::create(
                '@my-vendor/my-extension/backend-module.js',
            ),
        );
    }
}
