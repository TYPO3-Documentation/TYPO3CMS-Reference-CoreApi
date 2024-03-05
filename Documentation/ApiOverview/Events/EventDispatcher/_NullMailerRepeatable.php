<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Core\Mail\Event\AfterMailerInitializationEvent;
use TYPO3\CMS\Core\Mail\Event\BeforeMailerSentMessageEvent;

#[AsEventListener(
    identifier: 'my-extension/null-mailer-initialization',
    event: AfterMailerInitializationEvent::class,
)]
#[AsEventListener(
    identifier: 'my-extension/null-mailer-sent-message',
    event: BeforeMailerSentMessageEvent::class,
)]
final readonly class NullMailer
{
    public function __invoke(
        AfterMailerInitializationEvent | BeforeMailerSentMessageEvent $event,
    ): void {
        $event->getMailer()->injectMailSettings(['transport' => 'null']);
    }
}
