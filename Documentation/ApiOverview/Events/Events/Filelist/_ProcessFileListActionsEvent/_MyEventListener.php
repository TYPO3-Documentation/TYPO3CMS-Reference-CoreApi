<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\FileList\EventListener;

use TYPO3\CMS\Filelist\Event\ProcessFileListActionsEvent;

final class MyEventListener
{
    public function __invoke(ProcessFileListActionsEvent $event): void
    {
        // do your magic
    }
}
