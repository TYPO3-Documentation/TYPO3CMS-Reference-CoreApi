<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Resource\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Core\Resource\Event\AfterFileCommandProcessedEvent;

#[AsEventListener(
    identifier: 'my-extension/after-file-command-processed',
)]
final readonly class MyEventListener
{
    public function __invoke(AfterFileCommandProcessedEvent $event): void
    {
        // Do magic here
    }
}
