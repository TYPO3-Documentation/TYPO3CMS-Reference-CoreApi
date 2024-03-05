<?php

namespace MyVendor\MyExtension\Package\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Core\Package\Event\AfterPackageActivationEvent;

#[AsEventListener(
    identifier: 'my-extension/extension-activated',
)]
final readonly class MyEventListener
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
