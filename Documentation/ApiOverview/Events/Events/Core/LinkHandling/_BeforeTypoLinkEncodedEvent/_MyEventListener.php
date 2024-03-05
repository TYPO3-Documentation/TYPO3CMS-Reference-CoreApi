<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\LinkHandling\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Core\LinkHandling\Event\BeforeTypoLinkEncodedEvent;

#[AsEventListener(
    identifier: 'my-extension/before-typolink-encoded',
)]
final readonly class MyEventListener
{
    public function __invoke(BeforeTypoLinkEncodedEvent $event): void
    {
        $typoLinkParameters = $event->getParameters();

        if (str_contains($typoLinkParameters['class'] ?? '', 'foo')) {
            $typoLinkParameters['class'] .= ' bar';
            $event->setParameters($typoLinkParameters);
        }
    }
}
