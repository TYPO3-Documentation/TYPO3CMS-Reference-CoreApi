<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Frontend\Event\ModifyHrefLangTagsEvent;

// Important: Use the 'identifier' of the original event here to be replaced!
#[AsEventListener(
    identifier: 'ext-some-extension/modify-hreflang',
    after: 'typo3-seo/hreflangGenerator',
)]
final readonly class MySeoEventListener
{
    public function __invoke(ModifyHrefLangTagsEvent $event): void
    {
        // ... custom code which overrides the
        // original EXT:some-extension listener ...
    }
}
