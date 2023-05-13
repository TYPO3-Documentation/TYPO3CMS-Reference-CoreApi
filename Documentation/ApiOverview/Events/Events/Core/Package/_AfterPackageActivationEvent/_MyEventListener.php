<?php

namespace MyVendor\MyExtension\Package\EventListener;

use TYPO3\CMS\Core\Package\Event\AfterPackageActivationEvent;

final class MyEventListener
{
    public function __invoke(AfterPackageActivationEvent $event)
    {
        if ($event->getPackageKey() === 'my_extension') {
            $this->executeInstall();
        }
    }

    private function executeInstall(): void
    {
        // do something
    }
}
