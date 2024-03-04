<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\LinkHandling\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Core\LinkHandling\Event\AfterTypoLinkDecodedEvent;

#[AsEventListener(
    identifier: 'my-extension/after-typolink-decoded',
)]
final readonly class MyEventListener
{
    public function __invoke(AfterTypoLinkDecodedEvent $event): void
    {
        $typoLink = $event->getTypoLink();
        $typoLinkParts = $event->getTypoLinkParts();

        if (str_contains($typoLink, 'foo')) {
            $typoLinkParts['foo'] = 'bar';
            $event->setTypoLinkParts($typoLinkParts);
        }
    }
}
