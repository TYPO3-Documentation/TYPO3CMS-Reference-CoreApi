<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Form\Event\BeforeRenderableIsRemovedFromFormEvent;

final readonly class MyEventListener
{
    #[AsEventListener(
        identifier: 'my-extension/before-renderable-is-removed-from-form-event',
    )]
    public function __invoke(BeforeRenderableIsRemovedFromFormEvent $event): void
    {
        $event->preventRemoval = true;
        $renderable = $event->renderable;
        // Do something with the renderable
    }
}
