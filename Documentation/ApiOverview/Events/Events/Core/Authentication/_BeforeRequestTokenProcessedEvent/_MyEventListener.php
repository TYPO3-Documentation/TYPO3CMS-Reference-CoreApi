<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Authentication\EventListener;

use TYPO3\CMS\Core\Authentication\Event\BeforeRequestTokenProcessedEvent;
use TYPO3\CMS\Core\Security\RequestToken;

final class MyEventListener
{
    public function __invoke(BeforeRequestTokenProcessedEvent $event): void
    {
        $user = $event->getUser();
        $requestToken = $event->getRequestToken();
        // fine, there is a valid request token
        if ($requestToken instanceof RequestToken) {
            return;
        }

        // Validate individual requirements/checks
        // ...
        $event->setRequestToken(
            RequestToken::create('core/user-auth/' . $user->loginType)
        );
    }
}
