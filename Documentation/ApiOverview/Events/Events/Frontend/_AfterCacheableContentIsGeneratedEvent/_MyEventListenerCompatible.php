<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Frontend\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Core\Information\Typo3Version;
use TYPO3\CMS\Frontend\Event\AfterCacheableContentIsGeneratedEvent;

final readonly class MyEventListener
{
    #[AsEventListener('my-extension')]
    public function indexPageContent(AfterCacheableContentIsGeneratedEvent $event): void
    {
        if ((new Typo3Version())->getMajorVersion() < 14) {
            // @todo: Remove if() when TYPO3 v13 compatibility is dropped, keep else body only
            $tsfe = $event->getController();
            $content = $tsfe->content;
        } else {
            $content = $event->getContent();
        }
        // ... $content is manipulated here
        if ((new Typo3Version())->getMajorVersion() < 14) {
            // @todo: Remove if() when TYPO3 v13 compatibility is dropped, keep else body only
            $tsfe = $event->getController();
            $tsfe->content = $content;
        } else {
            $event->setContent($content);
        }
    }
}
