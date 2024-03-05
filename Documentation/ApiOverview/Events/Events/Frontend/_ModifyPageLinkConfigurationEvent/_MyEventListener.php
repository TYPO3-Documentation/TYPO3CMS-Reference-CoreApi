<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Frontend\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Frontend\Event\ModifyPageLinkConfigurationEvent;

#[AsEventListener(
    identifier: 'my-extension/modify-page-link-configuration',
)]
final readonly class MyEventListener
{
    public function __invoke(ModifyPageLinkConfigurationEvent $event): void
    {
        // Do your magic here
    }
}
