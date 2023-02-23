<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Backend\EventListener;

use TYPO3\CMS\Backend\Controller\Event\ModifyGenericBackendMessagesEvent;
use TYPO3\CMS\Core\Messaging\FlashMessage;

final class MyEventListener
{
    public function __invoke(ModifyGenericBackendMessagesEvent $event): void
    {
        // Add a custom message
        $event->addMessage(new FlashMessage('My custom message'));
    }
}
