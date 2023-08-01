<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\EventListener;

use TYPO3\CMS\Core\Mail\Event\AfterMailerInitializationEvent;

final class NullMailer
{
    public function __invoke(AfterMailerInitializationEvent $event): void
    {
        $event->getMailer()->injectMailSettings(['transport' => 'null']);
    }
}
