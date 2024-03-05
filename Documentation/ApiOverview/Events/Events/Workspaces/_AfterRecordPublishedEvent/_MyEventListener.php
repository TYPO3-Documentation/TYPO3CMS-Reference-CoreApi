<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Workspaces\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Workspaces\Event\AfterRecordPublishedEvent;

#[AsEventListener(
    identifier: 'my-extension/after-record-published',
)]
final readonly class MyEventListener
{
    public function __invoke(AfterRecordPublishedEvent $event): void
    {
        // Do your magic here
    }
}
