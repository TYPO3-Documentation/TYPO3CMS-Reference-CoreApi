<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Authentication\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Core\Authentication\Event\LoginAttemptFailedEvent;

#[AsEventListener(
    identifier: 'my-extension/login-attempt-failed',
)]
final readonly class MyEventListener
{
    public function __invoke(LoginAttemptFailedEvent $event): void
    {
        $normalizedParams = $event->getRequest()->getAttribute('normalizedParams');
        if ($normalizedParams->getRemoteAddress() !== '198.51.100.42') {
            // send an email because an external user attempt failed
        }
    }
}
