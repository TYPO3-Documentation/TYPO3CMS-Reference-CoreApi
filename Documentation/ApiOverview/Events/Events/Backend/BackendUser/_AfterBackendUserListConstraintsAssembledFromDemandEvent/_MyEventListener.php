<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Backend\EventListener;

use TYPO3\CMS\Beuser\Event\AfterBackendUserListConstraintsAssembledFromDemandEvent;
use TYPO3\CMS\Core\Attribute\AsEventListener;

final readonly class MyEventListener
{
    #[AsEventListener]
    public function __invoke(AfterBackendUserListConstraintsAssembledFromDemandEvent $event): void
    {
        $event->constraints[] = $event->query->eq('admin', 1);
    }
}
