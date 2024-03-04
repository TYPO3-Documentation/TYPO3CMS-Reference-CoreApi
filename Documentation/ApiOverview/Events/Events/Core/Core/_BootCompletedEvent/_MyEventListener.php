<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Bootstrap\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Core\Core\Event\BootCompletedEvent;

#[AsEventListener(
    identifier: 'my-extension/boot-completed',
)]
final readonly class MyEventListener
{
    public function __invoke(BootCompletedEvent $e): void
    {
        // Do your magic
    }
}
