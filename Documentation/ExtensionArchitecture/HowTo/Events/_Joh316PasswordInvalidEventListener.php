<?php
// EXT:my_extension/Classes/EventListener/Joh316PasswordInvalidEventListener.php

namespace MyVendor\MyExtension\EventListener;
use TYPO3\CMS\FrontendLogin\Event\PasswordChangeEvent;

final class Joh316PasswordInvalidEventListener
{
    public function __invoke(PasswordChangeEvent $event): void
    {
        if ($event->getRawPassword() === 'joh316') {
            $event->setAsInvalid('This password is not allowed');
        }
    }
}