<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Bootstrap\EventListener;

use TYPO3\CMS\Core\Core\Event\BootCompletedEvent;

final class MyEventListener
{
    public function __invoke(BootCompletedEvent $e): void
    {
        // Do your magic
    }
}
