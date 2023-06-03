<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Workspaces\EventListener;

use TYPO3\CMS\Workspaces\Event\AfterRecordPublishedEvent;

final class MyEventListener
{
    public function __invoke(AfterRecordPublishedEvent $event): void
    {
        // Do your magic here
    }
}
