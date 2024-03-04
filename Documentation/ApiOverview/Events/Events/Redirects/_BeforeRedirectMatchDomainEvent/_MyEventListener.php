<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Redirects\EventListener;

use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Redirects\Event\BeforeRedirectMatchDomainEvent;

#[AsEventListener(
    identifier: 'my-extension/before-redirect-match-domain',
)]
final readonly class MyEventListener
{
    public function __invoke(BeforeRedirectMatchDomainEvent $event): void
    {
        $matchedRedirectRecord = $this->customRedirectMatching($event);
        if ($matchedRedirectRecord !== null) {
            $event->setMatchedRedirect($matchedRedirectRecord);
        }
    }

    private function customRedirectMatching(BeforeRedirectMatchDomainEvent $event): ?array
    {
        // @todo Implement custom redirect record loading and matching. If
        //       a redirect based on custom logic is determined, return the
        //       :sql:`sys_redirect` tables conform redirect record.

        // Note: Below is simplified example code with no real value.
        $record = BackendUtility::getRecord('sys_redirect', 123);

        // Do custom matching logic against the record and return matched
        // record - if there is one.
        if ($record /* && custom condition against the record */) {
            return $record;
        }

        // Return null to indicate that no matched redirect could be found
        return null;
    }
}
