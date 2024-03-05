<?php

declare(strict_types=1);

namespace SomeVendor\SomeExtension\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Frontend\Event\ModifyHrefLangTagsEvent;

#[AsEventListener(
    identifier: 'ext-some-extension/modify-hreflang',
    after: 'typo3-seo/hreflangGenerator',
)]
final readonly class SeoEventListener
{
    public function __invoke(ModifyHrefLangTagsEvent $event): void
    {
        // ... custom code...
    }
}
