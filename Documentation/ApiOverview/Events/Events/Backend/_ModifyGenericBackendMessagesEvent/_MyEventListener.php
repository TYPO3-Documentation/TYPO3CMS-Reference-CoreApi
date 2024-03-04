<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Backend\EventListener;

use TYPO3\CMS\Backend\Controller\Event\ModifyGenericBackendMessagesEvent;
use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Core\Messaging\FlashMessage;

#[AsEventListener(
    identifier: 'my-extension/backend/add-message',
)]
final readonly class MyEventListener
{
    public function __invoke(ModifyGenericBackendMessagesEvent $event): void
    {
        // Add a custom message
        $event->addMessage(new FlashMessage('My custom message'));
    }
}
