<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Authentication\EventListener;

use TYPO3\CMS\Core\Authentication\BackendUserAuthentication;
use TYPO3\CMS\Core\Authentication\Event\AfterUserLoggedInEvent;

final class MyEventListener
{
    public function __invoke(AfterUserLoggedInEvent $event): void
    {
        if (
            $event->getUser() instanceof BackendUserAuthentication
            && $event->getUser()->isAdmin()
        ) {
            // Do something like: Clear all caches after login
        }
    }
}
