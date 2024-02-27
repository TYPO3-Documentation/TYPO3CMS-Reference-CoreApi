<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Redirects\EventListener;

use MyVendor\MyExtension\Redirects\CustomSource;
use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Redirects\Event\SlugRedirectChangeItemCreatedEvent;
use TYPO3\CMS\Redirects\RedirectUpdate\PlainSlugReplacementRedirectSource;
use TYPO3\CMS\Redirects\RedirectUpdate\RedirectSourceCollection;

#[AsEventListener(
    identifier: 'my-extension/redirects/add-redirect-source',
    after: 'redirects-add-plain-slug-replacement-source'
)]
final class MyEventListener
{
    public function __invoke(SlugRedirectChangeItemCreatedEvent $event): void
    {
        // Retrieve change item and sources
        $changeItem = $event->getSlugRedirectChangeItem();
        $sources = $changeItem->getSourcesCollection()->all();

        // Remove plain slug replacement redirect source from sources
        $sources = array_filter(
            $sources,
            fn($source) => !($source instanceof PlainSlugReplacementRedirectSource)
        );

        // Add custom source implementation
        $sources[] = new CustomSource();

        // Replace sources collection
        $changeItem = $changeItem->withSourcesCollection(
            new RedirectSourceCollection(...array_values($sources))
        );

        // Update changeItem in the event
        $event->setSlugRedirectChangeItem($changeItem);
    }
}
