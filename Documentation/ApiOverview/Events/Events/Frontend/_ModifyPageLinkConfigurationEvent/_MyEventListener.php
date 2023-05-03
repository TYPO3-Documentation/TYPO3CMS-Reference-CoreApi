<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Frontend\EventListener;

use TYPO3\CMS\Frontend\Event\ModifyPageLinkConfigurationEvent;

final class MyEventListener
{
    public function __invoke(ModifyPageLinkConfigurationEvent $event): void
    {
        // Do your magic here
    }
}
