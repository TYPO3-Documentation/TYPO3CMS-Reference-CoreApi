<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\EventListener;

use TYPO3\CMS\Frontend\Event\ModifyHrefLangTagsEvent;

final class MySeoEventListener
{
    public function __invoke(ModifyHrefLangTagsEvent $event): void
    {
        // ... custom code which overrides the
        // original EXT:some-extension listener ...
    }
}
