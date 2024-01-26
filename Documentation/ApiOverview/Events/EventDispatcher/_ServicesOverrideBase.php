<?php

declare(strict_types=1);

namespace SomeVendor\SomeExtension\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Frontend\Event\ModifyHrefLangTagsEvent;

// The PHP attribute is available for TYPO3 v13 and upwards;
// it can be set in TYPO3 v12 already and will not cause
// a problem, as long as you register the listener via Services.yaml.
#[AsEventListener(
    identifier: 'ext-some-extension/modify-hreflang',
    after: 'typo3-seo/hreflangGenerator',
)]
final class SeoEventListener
{
    public function __invoke(ModifyHrefLangTagsEvent $event): void
    {
        // ... custom code...
    }
}
