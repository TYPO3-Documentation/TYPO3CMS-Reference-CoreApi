<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Form\Event\AfterCurrentPageIsResolvedEvent;

#[AsEventListener(
    identifier: 'my-extension/after-current-page-is-resolved-event',
)]
final readonly class MyEventListener
{
    public function __invoke(AfterCurrentPageIsResolvedEvent $event): void
    {
        $event->currentPage->setRenderingOption('enabled', false);
    }
}
