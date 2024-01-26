<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Seo\EventListener;

use TYPO3\CMS\Seo\Event\ModifyUrlForCanonicalTagEvent;

final class MyEventListener
{
    public function __invoke(ModifyUrlForCanonicalTagEvent $event): void
    {
        // Note: $event->getUrl() is dispatched with the empty string value ''
        $currentUrl = $event->getRequest()->getUri();
        $newCanonical = $currentUrl->withHost('example.com');
        $event->setUrl((string)$newCanonical);
    }
}
