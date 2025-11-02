<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Backend\EventListener;

use TYPO3\CMS\Backend\View\Event\PageContentPreviewRenderingEvent;
use TYPO3\CMS\Core\Attribute\AsEventListener;

#[AsEventListener(
    identifier: 'my-extension/preview-rendering-example-ctype',
)]
final readonly class MyEventListener
{
    public function __invoke(PageContentPreviewRenderingEvent $event): void
    {
        if ($event->getRecord()->getFullType() !== 'tt_content.example_ctype') {
            return;
        }

        if ($event->getRecord()->has('header')) {
            $header = $event->getRecord()->get('header');
            $event->setPreviewContent(
                sprintf('<h1>%s</h1></h1><div>...</div>', $header),
            );
        }
    }
}
