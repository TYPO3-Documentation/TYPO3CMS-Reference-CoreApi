<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Configuration\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Core\TypoScript\IncludeTree\Event\ModifyLoadedPageTsConfigEvent;

#[AsEventListener(
    identifier: 'my-extension/configuration/loader',
)]
final readonly class MyEventListener
{
    public function __invoke(ModifyLoadedPageTsConfigEvent $event): void
    {
        // ... your logic
    }
}
