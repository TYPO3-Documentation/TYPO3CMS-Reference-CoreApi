<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Form\Event\BeforeRenderableIsRenderedEvent;

final readonly class MyEventListener
{
    #[AsEventListener(
        identifier: 'my-extension/before-renderable-is-rendered',
    )]
    public function __invoke(BeforeRenderableIsRenderedEvent $event): void
    {
        $renderable = $event->renderable;
        if ($renderable->getType() !== 'Date') {
            return;
        }
        $date = $event->formRuntime[$renderable->getIdentifier()];
        if ($date instanceof \DateTime) {
            $event->formRuntime[$renderable->getIdentifier()] = $date->format('Y-m-d');
        }
    }
}
