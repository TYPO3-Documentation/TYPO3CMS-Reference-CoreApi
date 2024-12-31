<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Mail\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Core\Mail\Event\BeforeMailerSentMessageEvent;
use TYPO3\CMS\Core\Mail\MailMessage;

#[AsEventListener(
    identifier: 'my-extension/add-mail-message-bcc',
)]
final readonly class AddMailMessageBcc
{
    public function __invoke(BeforeMailerSentMessageEvent $event): void
    {
        $message = $event->getMessage();
        if ($message instanceof MailMessage) {
            $message->addBcc('me@example.com');
        }
        $event->setMessage($message);
    }
}
