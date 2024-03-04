<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Redirects\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Redirects\Event\RedirectWasHitEvent;

#[AsEventListener(
    identifier: 'my-extension/redirects/validate-hit-count',
    before: 'redirects-increment-hit-count',
)]
final readonly class MyEventListener
{
    public function __invoke(RedirectWasHitEvent $event): void
    {
        $matchedRedirect = $event->getMatchedRedirect();

        // This will disable the hit count increment in case the target
        // is the page 123 and the request is from the monitoring tool.
        if (str_contains($matchedRedirect['target'], 'uid=123')
            && $event->getRequest()->getAttribute('normalizedParams')
                ->getHttpUserAgent() === 'my monitoring tool'
        ) {
            $matchedRedirect['disable_hitcount'] = true;
            $event->setMatchedRedirect(
                $matchedRedirect,
            );

            // Also add a custom response header
            $event->setResponse(
                $event->getResponse()->withAddedHeader(
                    'X-My-Custom-Header',
                    'Hit count increment skipped',
                ),
            );
        }
    }
}
