<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\LinkHandling\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Core\LinkHandling\Event\AfterLinkResolvedByStringRepresentationEvent;

#[AsEventListener(
    identifier: 'my-extension/after-link-resolved-by-string-representation',
)]
final readonly class MyEventListener
{
    public function __invoke(AfterLinkResolvedByStringRepresentationEvent $event): void
    {
        if (str_contains($event->getUrn(), 'myhandler://123')) {
            $event->setResult([
                'type' => 'my-type',
            ]);
        }
    }
}
