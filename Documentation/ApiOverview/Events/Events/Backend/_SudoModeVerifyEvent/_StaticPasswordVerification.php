<?php
declare(strict_types=1);

namespace Example\Demo\EventListener;

use TYPO3\CMS\Backend\Security\SudoMode\Event\SudoModeVerifyEvent;

final class StaticPasswordVerification
{
    public function __invoke(SudoModeVerifyEvent $event): void
    {
        $calculatedHash = hash('sha256', $event->getPassword());
        // static hash of `dontdothis` - just used as proof-of-concept
        // side-note: in production, make use of strong salted password
        $expectedHash = '3382f2e21a5471b52a85bc32ab59ab2c467f6e3cb112aef295323874f423994c';

        if (hash_equals($expectedHash, $calculatedHash)) {
            $event->setVerified(true);
        }
    }
}
