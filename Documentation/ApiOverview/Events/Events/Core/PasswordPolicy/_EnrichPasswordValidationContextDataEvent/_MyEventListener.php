<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\PasswordPolicy\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Core\DataHandling\DataHandler;
use TYPO3\CMS\Core\PasswordPolicy\Event\EnrichPasswordValidationContextDataEvent;

#[AsEventListener(
    identifier: 'my-extension/enrich-context-data-event-listener',
)]
final readonly class MyEventListener
{
    public function __invoke(EnrichPasswordValidationContextDataEvent $event): void
    {
        if ($event->getInitiatingClass() === DataHandler::class) {
            $event->getContextData()->setData('currentMiddleName', $event->getUserData()['middle_name'] ?? '');
            $event->getContextData()->setData('currentEmail', $event->getUserData()['email'] ?? '');
        }
    }
}
