<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Core\Mail\Event\AfterMailerSentMessageEvent;

#[AsEventListener(
    identifier: 'my-extension/null-mailer',
    before: 'someIdentifier, anotherIdentifier',
)]
final readonly class MailerEventListener
{
    public function __invoke(AfterMailerSentMessageEvent $event): void
    {
        // do something
    }
}
