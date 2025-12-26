<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Core\Resource\Event\SanitizeFileNameEvent;

#[AsEventListener(
    identifier: 'my-extension/seo-friendly-filename',
)]
final readonly class SeoFriendlyFileNameListener
{
    public function __invoke(SanitizeFileNameEvent $event): void
    {
        $originalFileName = $event->getOriginalFileName();

        if (!str_contains($originalFileName, ' ')) {
            return;
        }
        // Apply custom logic based on the original file name
        $customFileName = str_replace(' ', '-', $originalFileName);

        $event->setFileName($customFileName);
    }
}
