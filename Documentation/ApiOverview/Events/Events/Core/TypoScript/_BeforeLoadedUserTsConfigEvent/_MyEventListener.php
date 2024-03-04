<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\TypoScript\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Core\TypoScript\IncludeTree\Event\BeforeLoadedUserTsConfigEvent;

#[AsEventListener(
    identifier: 'my-extension/global-usertsconfig',
)]
final readonly class MyEventListener
{
    public function __invoke(BeforeLoadedUserTsConfigEvent $event): void
    {
        $event->addTsConfig('global = a global setting');
    }
}
