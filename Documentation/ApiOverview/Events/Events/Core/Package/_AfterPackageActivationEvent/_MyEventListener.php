<?php

namespace WCO\WcoLdap\EventListener;

use TYPO3\CMS\Core\Package\Event\AfterPackageActivationEvent;

class Setup
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
