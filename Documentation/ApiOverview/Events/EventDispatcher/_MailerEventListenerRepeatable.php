<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Core\Mail\Event\AfterMailerSentMessageEvent;
use TYPO3\CMS\Core\Mail\Event\BeforeMailerSentMessageEvent;

#[AsEventListener(
    identifier: 'my-extension/null-mailer-initialization',
    event: AfterMailerSentMessageEvent::class,
)]
#[AsEventListener(
    identifier: 'my-extension/null-mailer-sent-message',
    event: BeforeMailerSentMessageEvent::class,
)]
final readonly class MailerEventListener
{
    public function __invoke(
        AfterMailerSentMessageEvent | BeforeMailerSentMessageEvent $event,
    ): void {
        // do something
    }
}