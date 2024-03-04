<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Mail\EventListener;

use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Core\Mail\Event\BeforeMailerSentMessageEvent;

#[AsEventListener(
    identifier: 'my-extension/modify-message',
)]
final readonly class MyEventListener
{
    public function __invoke(BeforeMailerSentMessageEvent $event): void
    {
        $message = $event->getMessage();

        // If $message is an Email implementation, add an additional recipient
        if ($message instanceof Email) {
            $message->addCc(new Address('cc_recipient@example.org'));
        }
    }
}
