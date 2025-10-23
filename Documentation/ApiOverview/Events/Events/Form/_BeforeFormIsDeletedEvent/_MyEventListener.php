<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Form\Event\BeforeFormIsDeletedEvent;

#[AsEventListener(
    identifier: 'my-extension/before-form-is-deleted',
)]
final readonly class MyEventListener
{
    public function __invoke(BeforeFormIsDeletedEvent $event): void
    {
        $event->preventDeletion = true;
        $persistenceIdentifier = $event->formPersistenceIdentifier;
        // Do something with the persistence identifier
    }
}
