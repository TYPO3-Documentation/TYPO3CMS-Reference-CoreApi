<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Form\Event\BeforeRenderableIsAddedToFormEvent;

final readonly class MyEventListener
{
    #[AsEventListener(
        identifier: 'my-extension/before-renderable-is-added-to-form-event',
    )]
    public function __invoke(BeforeRenderableIsAddedToFormEvent $event): void
    {
        $event->renderable->setLabel('foo');
    }
}
