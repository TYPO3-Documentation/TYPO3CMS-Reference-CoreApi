<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\TypoScript\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Core\TypoScript\IncludeTree\Event\BeforeLoadedPageTsConfigEvent;

#[AsEventListener(
    identifier: 'my-extension/global-pagetsconfig',
)]
final readonly class MyEventListener
{
    public function __invoke(BeforeLoadedPageTsConfigEvent $event): void
    {
        $event->addTsConfig('global = a global setting');
    }
}
