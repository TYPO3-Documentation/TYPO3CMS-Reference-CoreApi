<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Form\Event\BeforeFormIsDuplicatedEvent;

#[AsEventListener(
    identifier: 'my-extension/before-form-is-duplicated',
)]
final readonly class MyEventListener
{
    public function __invoke(BeforeFormIsDuplicatedEvent $event): void
    {
        $event->form['label'] = 'foo';
    }
}
