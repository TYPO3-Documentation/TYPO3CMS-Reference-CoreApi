<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Backend\EventListener;

use TYPO3\CMS\Backend\Template\Components\ModifyButtonBarEvent;
use TYPO3\CMS\Core\Attribute\AsEventListener;

#[AsEventListener(
    identifier: 'my-extension/backend/modify-button-bar',
)]
final readonly class MyEventListener
{
    public function __invoke(ModifyButtonBarEvent $event): void
    {
        // Do your magic here
    }
}
