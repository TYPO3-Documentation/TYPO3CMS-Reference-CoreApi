<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Frontend\Event\ModifyHrefLangTagsEvent;

// The PHP attribute is available for TYPO3 v13 and upwards;
// it can be set in TYPO3 v12 already and will not cause
// a problem, as long as you register the listener via Services.yaml.

// Important: Use the 'identifier' of the original event here to be replaced!
#[AsEventListener(
    identifier: 'ext-some-extension/modify-hreflang',
    after: 'typo3-seo/hreflangGenerator',
)]
final class MySeoEventListener
{
    public function __invoke(ModifyHrefLangTagsEvent $event): void
    {
        // ... custom code which overrides the
        // original EXT:some-extension listener ...
    }
}
