<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Resource\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Core\Resource\Event\ModifyFileDumpEvent;

#[AsEventListener(
    identifier: 'my-extension/modify-file-dump',
)]
final readonly class MyEventListener
{
    public function __invoke(ModifyFileDumpEvent $event): void
    {
        // Do magic here
    }
}
