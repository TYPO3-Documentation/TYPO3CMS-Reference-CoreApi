<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Core\Mail\Event\AfterMailerInitializationEvent;
use TYPO3\CMS\Core\Mail\Event\BeforeMailerSentMessageEvent;

final class NullMailer
{
    #[AsEventListener(identifier: 'my-extension/null-mailer-initialization')]
    #[AsEventListener(identifier: 'my-extension/null-mailer-sent-message')]
    public function __invoke(
        AfterMailerInitializationEvent | BeforeMailerSentMessageEvent $event
    ): void {
        $event->getMailer()->injectMailSettings(['transport' => 'null']);
    }
}
