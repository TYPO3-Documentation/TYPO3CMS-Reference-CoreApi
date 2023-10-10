<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Configuration\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Core\Configuration\Event\BeforeTcaOverridesEvent;

#[AsEventListener(
    identifier: 'my-extension/before-tca-overrides'
)]
final class MyEventListener
{
    public function __invoke(BeforeTcaOverridesEvent $event): void
    {
        $tca = $event->getTca();
        $tca['tt_content']['columns']['header']['config']['max'] = 100;
        $event->setTca($tca);
    }
}
