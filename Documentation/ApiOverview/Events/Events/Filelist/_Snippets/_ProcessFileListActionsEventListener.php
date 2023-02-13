<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\FileList;

use TYPO3\CMS\Filelist\Event\ProcessFileListActionsEvent;

final class ProcessFileListActionsEventListener
{
    public function __invoke(ProcessFileListActionsEvent $event): void
    {
        // do your magic
    }
}
