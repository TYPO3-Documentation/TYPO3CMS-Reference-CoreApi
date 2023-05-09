<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Mail\EventListener;

use TYPO3\CMS\Core\Mail\Event\AfterMailerInitializationEvent;

final class MyEventListener
{
    public function __invoke(AfterMailerInitializationEvent $event): void
    {
        $event->getMailer()->injectMailSettings(['transport' => 'null']);
    }
}
