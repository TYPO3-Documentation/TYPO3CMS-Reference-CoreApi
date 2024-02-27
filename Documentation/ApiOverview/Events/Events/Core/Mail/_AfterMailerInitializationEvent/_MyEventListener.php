<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Mail\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Core\Mail\Event\AfterMailerInitializationEvent;

#[AsEventListener(
    identifier: 'my-extension/after-mailer-initialization'
)]
final class MyEventListener
{
    public function __invoke(AfterMailerInitializationEvent $event): void
    {
        $event->getMailer()->injectMailSettings(['transport' => 'null']);
    }
}
