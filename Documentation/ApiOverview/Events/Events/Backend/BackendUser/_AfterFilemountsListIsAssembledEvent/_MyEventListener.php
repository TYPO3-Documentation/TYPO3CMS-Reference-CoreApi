<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Backend\EventListener;

use TYPO3\CMS\Beuser\Event\AfterFilemountsListIsAssembledEvent;
use TYPO3\CMS\Core\Attribute\AsEventListener;

final readonly class MyEventListener
{
    #[AsEventListener]
    public function __invoke(AfterFilemountsListIsAssembledEvent $event): void
    {
        array_pop($event->filemounts);
    }
}
