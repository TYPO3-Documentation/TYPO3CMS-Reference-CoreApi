<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\FileList\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Filelist\Event\AfterFileListRowPreparedEvent;

#[AsEventListener(
    identifier: 'my-extension/decorate-file-list-column',
)]
final readonly class DecorateFileListColumnEventListener
{
    public function __invoke(AfterFileListRowPreparedEvent $event): void
    {
        $data = $event->getData();
        // Modify the already-rendered value of a specific column
        $data['my_column'] = 'My custom value';
        $event->setData($data);
    }
}
