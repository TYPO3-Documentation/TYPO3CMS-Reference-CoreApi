<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Mail\EventListener;

use Psr\Log\LoggerInterface;
use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Core\Mail\Event\AfterMailerSentMessageEvent;
use TYPO3\CMS\Core\Mail\Mailer;

#[AsEventListener(
    identifier: 'my-extension/process-sent-message',
)]
final readonly class MyEventListener
{
    public function __construct(
        private readonly LoggerInterface $logger,
    ) {}

    public function __invoke(AfterMailerSentMessageEvent $event): void
    {
        $mailer = $event->getMailer();
        if (!$mailer instanceof Mailer) {
            return;
        }

        $sentMessage = $mailer->getSentMessage();
        if ($sentMessage !== null) {
            $this->logger->debug($sentMessage->getDebug());
        }
    }
}
