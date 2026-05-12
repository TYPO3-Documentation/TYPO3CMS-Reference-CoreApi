<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\ContentSecurityPolicy\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Core\Security\ContentSecurityPolicy\Event\BeforePersistingReportEvent;
use TYPO3\CMS\Core\Security\ContentSecurityPolicy\Reporting\Report;

#[AsEventListener(
    identifier: 'my-extension/before-persisting-report',
)]
final readonly class MyEventListener
{
    private const BROWSER_PREFIXES = [
        'chrome-extension://',
        'moz-extension://',
        'safari-extension://',
    ];

    public function __invoke(BeforePersistingReportEvent $event): void
    {
        // Avoid persisting CSP violations that were caused by browser extensions
        $blockedUri = $event->originalReport->details['blocked-uri'] ?? null;
        if (is_string($blockedUri) && $this->isBrowserExtensions($blockedUri)) {
            $event->report = null;
            return;
        }
        // Otherwise adjust report and provide custom metadata
        $event->report = new Report(
            $event->originalReport->scope,
            $event->originalReport->status,
            $event->originalReport->requestTime,
            array_merge(
                $event->originalReport->meta,
                ['x-example' => '... additional meta-data ...'],
            ),
            $event->originalReport->details,
            $event->originalReport->summary,
            $event->originalReport->uuid,
            $event->originalReport->created,
            $event->originalReport->changed,
        );
    }

    private function isBrowserExtensions(string $blockedUri): bool
    {
        foreach (self::BROWSER_PREFIXES as $prefix) {
            if (str_starts_with($blockedUri, $prefix)) {
                return true;
            }
        }
        return false;
    }
}
