<?php

declare(strict_types=1);
namespace MyVendor\MyExtension\Backend;

use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Routing\InvalidRouteArgumentsException;
use TYPO3\CMS\Core\Routing\RouterInterface;
use TYPO3\CMS\Core\Routing\UnableToLinkToPageException;
use TYPO3\CMS\Core\Site\Entity\Site;
use TYPO3\CMS\Core\Site\Entity\SiteLanguage;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Redirects\Event\SlugRedirectChangeItemCreatedEvent;
use TYPO3\CMS\Redirects\RedirectUpdate\PageTypeSource;
use TYPO3\CMS\Redirects\RedirectUpdate\RedirectSourceCollection;
use TYPO3\CMS\Redirects\RedirectUpdate\RedirectSourceInterface;

final class MyEventListener
{
    protected array $customPageTypes = [ 1234, 169999 ];

    public function __invoke(
        SlugRedirectChangeItemCreatedEvent $event
    ): void {
        $changeItem = $event->getSlugRedirectChangeItem();
        $sources = $changeItem->getSourcesCollection()->all();

        foreach ($this->customPageTypes as $pageType) {
            try {
                $pageTypeSource = $this->createPageTypeSource(
                    $changeItem->getPageId(),
                    $pageType,
                    $changeItem->getSite(),
                    $changeItem->getSiteLanguage(),
                );
                if ($pageTypeSource === null) {
                    continue;
                }
            } catch (UnableToLinkToPageException) {
                // Could not properly link to page. Continue to next page type
                continue;
            }

            if ($this->isDuplicate($pageTypeSource, ...$sources)) {
                // not adding duplicate,
                continue;
            }

            $sources[] = $pageTypeSource;
        }

        // update sources
        $changeItem = $changeItem->withSourcesCollection(
            new RedirectSourceCollection(
                ...array_values($sources)
            )
        );

        // update change item with updated sources
        $event->setSlugRedirectChangeItem($changeItem);
    }

    private function isDuplicate(
        PageTypeSource $pageTypeSource,
        RedirectSourceInterface ...$sources
    ): bool {
        foreach ($sources as $existingSource) {
            if ($existingSource instanceof PageTypeSource
                && $existingSource->getHost() === $pageTypeSource->getHost()
                && $existingSource->getPath() === $pageTypeSource->getPath()
            ) {
                // we do not check for the type, as that is irrelevant. Same
                // host+path tuple would lead to duplicated redirects if
                // type differs.
                return true;
            }
        }
        return false;
    }

    private function createPageTypeSource(
        int $pageUid,
        int $pageType,
        Site $site,
        SiteLanguage $siteLanguage
    ): ?PageTypeSource {
        if ($pageType === 0) {
            // pageType 0 is handled by \TYPO3\CMS\Redirects\EventListener\AddPageTypeZeroSource
            return null;
        }

        try {
            $context = GeneralUtility::makeInstance(Context::class);
            $uri = $site->getRouter($context)->generateUri(
                $pageUid,
                [
                    '_language' => $siteLanguage,
                    'type' => $pageType,
                ],
                '',
                RouterInterface::ABSOLUTE_URL
            );
            return new PageTypeSource(
                $uri->getHost() ?: '*',
                $uri->getPath(),
                $pageType,
                [
                    'type' => $pageType,
                ],
            );
        } catch (\InvalidArgumentException | InvalidRouteArgumentsException $e) {
            throw new UnableToLinkToPageException(
                sprintf(
                    'The link to the page with ID "%d" and type "%d" could not be generated: %s',
                    $pageUid,
                    $pageType,
                    $e->getMessage()
                ),
                1675618235,
                $e
            );
        }
    }
}
