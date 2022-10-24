<?php
// EXT:my_extension/Classes/EventListener/Joh316PasswordInvalidator.php
declare(strict_types=1);

namespace MyVendor\MyExtension\EventListener;

use TYPO3\CMS\FrontendLogin\Event\PasswordChangeEvent;

/**
 * The password 'joh316' was historically used as default password for
 * the TYPO3 install tool.
 * Today this password is an unsecure choice as it is well-known, too short
 * and does not contain capital letters or special characters.
 */
final class Joh316PasswordInvalidator
{
    public function __invoke(PasswordChangeEvent $event): void
    {
        if ($event->getRawPassword() === 'joh316') {
            $event->setAsInvalid('This password is not allowed');
        }
    }
}
