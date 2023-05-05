<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Backend;

use TYPO3\CMS\Redirects\Event\SlugRedirectChangeItemCreatedEvent;
use TYPO3\CMS\Redirects\RedirectUpdate\PageTypeSource;
use TYPO3\CMS\Redirects\RedirectUpdate\PlainSlugReplacementRedirectSource;
use TYPO3\CMS\Redirects\RedirectUpdate\RedirectSourceCollection;
use TYPO3\CMS\Redirects\RedirectUpdate\RedirectSourceInterface;

final class MyEventListener
{
    public function __invoke(
        SlugRedirectChangeItemCreatedEvent $event
    ): void {
        $changeItem = $event->getSlugRedirectChangeItem();
        $sources = $changeItem->getSourcesCollection()->all();
        $pageTypeZeroSource = $this->getPageTypeZeroSource(
            ...array_values($sources)
        );
        if ($pageTypeZeroSource === null) {
            // nothing we can do - no page type 0 source found
            return;
        }

        // Remove plain slug replacement redirect source from sources. We
        // already know, that if it is there it differs from the page type
        // 0 source, therefor it is safe to simply remove it by class check.
        $sources = array_filter(
            $sources,
            static fn ($source) => !($source instanceof PlainSlugReplacementRedirectSource)
        );

        // update sources
        $changeItem = $changeItem->withSourcesCollection(
            new RedirectSourceCollection(
                ...array_values($sources)
            )
        );

        // update change item with updated sources
        $event->setSlugRedirectChangeItem($changeItem);
    }

    private function getPageTypeZeroSource(
        RedirectSourceInterface ...$sources
    ): ?PageTypeSource {
        foreach ($sources as $source) {
            if ($source instanceof PageTypeSource
                && $source->getPageType() === 0
            ) {
                return $source;
            }
        }
        return null;
    }
}
