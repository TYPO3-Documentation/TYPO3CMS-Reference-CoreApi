<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\FileList\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Filelist\Event\ProcessFileListActionsEvent;

#[AsEventListener(
    identifier: 'my-extension/process-file-list',
)]
final readonly class MyEventListener
{
    public function __invoke(ProcessFileListActionsEvent $event): void
    {
        // do your magic
    }
}
