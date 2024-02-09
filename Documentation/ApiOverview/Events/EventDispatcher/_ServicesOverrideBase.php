<?php

declare(strict_types=1);

namespace SomeVendor\SomeExtension\EventListener;

use TYPO3\CMS\Frontend\Event\ModifyHrefLangTagsEvent;

final class SeoEventListener
{
    public function __invoke(ModifyHrefLangTagsEvent $event): void
    {
        // ... custom code...
    }
}
