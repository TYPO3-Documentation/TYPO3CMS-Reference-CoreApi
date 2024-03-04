<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Authentication\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Core\Authentication\Event\BeforeRequestTokenProcessedEvent;
use TYPO3\CMS\Core\Security\RequestToken;

#[AsEventListener(
    identifier: 'my-extension/process-request-token-listener',
)]
final readonly class MyEventListener
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
            RequestToken::create('core/user-auth/' . strtolower($user->loginType)),
        );
    }
}
