<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Backend\EventListener;

use TYPO3\CMS\Backend\Form\Event\ModifyEditFormUserAccessEvent;

final class MyEventListener
{
    public function __invoke(ModifyEditFormUserAccessEvent $event): void
    {
        // Deny access for creating records of a custom table
        if ($event->getTableName() === 'tx_myext_domain_model_mytable' && $event->getCommand() === 'new') {
            $event->denyUserAccess();
        }
    }
}
