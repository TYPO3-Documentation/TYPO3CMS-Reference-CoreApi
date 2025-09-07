<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Form\Event\BeforeFormIsSavedEvent;

#[AsEventListener(
    identifier: 'my-extension/before-form-is-saved',
)]
final readonly class MyEventListener
{
    public function __invoke(BeforeFormIsSavedEvent $event): void
    {
        $event->form['label'] = 'foo';
    }
}
