<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Backend\EventListener;

use TYPO3\CMS\Backend\Template\Components\ModifyButtonBarEvent;

final class MyEventListener
{
    public function __invoke(ModifyButtonBarEvent $event): void
    {
        // Do your magic here
    }
}
