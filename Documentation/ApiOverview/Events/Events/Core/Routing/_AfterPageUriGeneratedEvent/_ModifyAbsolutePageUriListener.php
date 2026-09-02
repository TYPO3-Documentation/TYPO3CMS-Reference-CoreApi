<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Core\Routing\Event\AfterPageUriGeneratedEvent;
use TYPO3\CMS\Core\Routing\RouterInterface;

#[AsEventListener('my-extension/modify-absolute-page-uri')]
final readonly class ModifyAbsolutePageUriListener
{
    private const TRACKED_SITE_IDENTIFIER = 'main-site';

    public function __invoke(AfterPageUriGeneratedEvent $event): void
    {
        // Be context-aware: a utm_source parameter only makes sense on a
        // fully-qualified URL meant for external use, not on the backend
        // previews, sitemaps, redirects and other contexts this event
        // also fires for.
        if ($event->getType() !== RouterInterface::ABSOLUTE_URL) {
            return;
        }
        // Only add it for the site this campaign targets.
        if ($event->getSite()->getIdentifier() !== self::TRACKED_SITE_IDENTIFIER) {
            return;
        }

        // Append a tracking query parameter to the generated URI
        $uri = $event->getUri();
        parse_str($uri->getQuery(), $queryParameters);
        $queryParameters['utm_source'] = 'newsletter';
        $uri = $uri->withQuery(http_build_query($queryParameters));

        $event->setUri($uri);
    }
}
