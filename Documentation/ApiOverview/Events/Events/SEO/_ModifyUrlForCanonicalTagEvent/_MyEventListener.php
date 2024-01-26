<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Seo\EventListener;

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Seo\Event\ModifyUrlForCanonicalTagEvent;

#[AsEventListener(
    identifier: 'my-extension/modify-url-for-canonical-tag'
)]
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
