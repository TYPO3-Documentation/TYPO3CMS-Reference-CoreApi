<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\EventListener;

use MyVendor\MyExtension\KeyPairHandling\KeyFileService;
use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Context\UserAspect;
use TYPO3\CMS\Core\Type\ContextualFeedbackSeverity;
use TYPO3\CMS\FrontendLogin\Event\LogoutConfirmedEvent;

#[AsEventListener(
    identifier: 'my-extension/delete-private-key-on-logout',
)]
final readonly class LogoutEventListener
{
    public function __construct(
        private KeyFileService $keyFileService,
        private Context $context,
    ) {}

    public function __invoke(LogoutConfirmedEvent $event): void
    {
        $userAspect = $this->context->getAspect('frontend.user');
        assert($userAspect instanceof UserAspect);
        if ($this->keyFileService->deletePrivateKey($userAspect)) {
            $event->getController()->addFlashMessage('Your private key has been deleted. ', '', ContextualFeedbackSeverity::NOTICE);
        } else {
            $event->getController()->addFlashMessage('Deletion of your private key failed. It will be deleted automatically within 15 minutes by a scheduler task. ', '', ContextualFeedbackSeverity::WARNING);
        }
    }
}
