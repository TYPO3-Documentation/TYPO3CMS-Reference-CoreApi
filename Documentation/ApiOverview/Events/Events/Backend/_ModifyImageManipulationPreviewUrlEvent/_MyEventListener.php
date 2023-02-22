<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Backend\EventListener;

use TYPO3\CMS\Backend\Form\Event\ModifyImageManipulationPreviewUrlEvent;

final class MyEventListener
{
    public function __invoke(ModifyImageManipulationPreviewUrlEvent $event): void
    {
        $event->setPreviewUrl('https://example.com/some/preview/url');
    }
}
