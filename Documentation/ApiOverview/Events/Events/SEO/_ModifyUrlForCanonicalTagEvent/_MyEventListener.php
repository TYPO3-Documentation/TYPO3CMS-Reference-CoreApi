<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Seo\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Seo\Event\ModifyUrlForCanonicalTagEvent;
use TYPO3\CMS\Seo\Exception\CanonicalGenerationDisabledException;

#[AsEventListener(
    identifier: 'my-extension/modify-url-for-canonical-tag',
)]
final readonly class MyEventListener
{
    public function __invoke(ModifyUrlForCanonicalTagEvent $event): void
    {
        if ($event->getCanonicalGenerationDisabledException() instanceof CanonicalGenerationDisabledException) {
            return;
        }

        // Only set the canonical in our example when the tag is not disabled
        // via TypoScript or via "no_index" in the page properties.
        $currentUrl = $event->getRequest()->getUri();
        $newCanonical = $currentUrl->withHost('example.com');
        $event->setUrl((string)$newCanonical);
    }
}
