<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Frontend\EventListener;

use TYPO3\CMS\Frontend\Event\AfterLinkIsGeneratedEvent;

final class MyEventListener
{
    public function __invoke(AfterLinkIsGeneratedEvent $event): void
    {
        $linkResult = $event->getLinkResult()->withAttribute(
            'data-enable-lightbox',
            'true'
        );
        $event->setLinkResult($linkResult);
    }
}
