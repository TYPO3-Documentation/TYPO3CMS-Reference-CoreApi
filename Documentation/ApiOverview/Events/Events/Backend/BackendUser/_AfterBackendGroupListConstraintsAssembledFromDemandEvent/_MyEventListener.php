<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Backend\EventListener;

use TYPO3\CMS\Beuser\Event\AfterBackendGroupListConstraintsAssembledFromDemandEvent;
use TYPO3\CMS\Core\Attribute\AsEventListener;

final readonly class MyEventListener
{
    #[AsEventListener]
    public function __invoke(AfterBackendGroupListConstraintsAssembledFromDemandEvent $event): void
    {
        $event->constraints[] = $event->query->eq('workspace_perms', 1);
    }
}
