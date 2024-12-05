<?php

declare(strict_types=1);

namespace Vendor\MyPackage\Backend\EventListener;

use TYPO3\CMS\Backend\Authentication\Event\PasswordHasBeenResetEvent;
use TYPO3\CMS\Core\Attribute\AsEventListener;

final class PasswordHasBeenResetEventListener
{
    #[AsEventListener('my-package/backend/password-has-been-reset')]
    public function __invoke(PasswordHasBeenResetEvent $event): void
    {
        $userUid = $event->userId;
        // Do something with the be_user UID
    }
}
