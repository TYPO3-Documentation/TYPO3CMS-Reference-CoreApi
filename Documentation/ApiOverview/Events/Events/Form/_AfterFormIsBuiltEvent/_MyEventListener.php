<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Form\Event\AfterFormIsBuiltEvent;

final readonly class MyEventListener
{
    #[AsEventListener(
        identifier: 'my-extension/after-form-is-built',
    )]
    public function __invoke(AfterFormIsBuiltEvent $event): void
    {
        $event->form->setLabel('foo');
    }
}
