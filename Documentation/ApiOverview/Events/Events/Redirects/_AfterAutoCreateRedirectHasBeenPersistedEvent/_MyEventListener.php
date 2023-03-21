<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Redirects\EventListener;

use TYPO3\CMS\Redirects\Event\AfterAutoCreateRedirectHasBeenPersistedEvent;
use TYPO3\CMS\Redirects\RedirectUpdate\PlainSlugReplacementRedirectSource;

final class MyEventListener
{
    public function __invoke(AfterAutoCreateRedirectHasBeenPersistedEvent $event): void
    {
        $redirectUid = $event->getRedirectRecord()['uid'] ?? null;
        if ($redirectUid === null
            && !($event->getSource() instanceof PlainSlugReplacementRedirectSource)
        ) {
            return;
        }

        // Implement code what should be done with this information. For example,
        // write to another table, call a REST API or similar. Find your
        // use case.
    }
}
