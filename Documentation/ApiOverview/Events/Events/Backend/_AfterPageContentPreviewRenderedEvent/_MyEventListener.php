<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Backend\EventListener;

use TYPO3\CMS\Backend\View\Event\AfterPageContentPreviewRenderedEvent;
use TYPO3\CMS\Core\Attribute\AsEventListener;

#[AsEventListener(
    identifier: 'my-extension',
)]
final readonly class MyEventListener
{
    public function __invoke(AfterPageContentPreviewRenderedEvent $event): void
    {
        $content = 'before<hr />'. $event->getPreviewContent() . '<hr />after';
        $event->setPreviewContent($content);
    }
}
