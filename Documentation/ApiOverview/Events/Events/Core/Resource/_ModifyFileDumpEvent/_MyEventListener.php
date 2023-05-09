<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Resource\EventListener;

use TYPO3\CMS\Core\Resource\Event\ModifyFileDumpEvent;

final class MyEventListener
{
    public function __invoke(ModifyFileDumpEvent $event): void
    {
        // Do magic here
    }
}
