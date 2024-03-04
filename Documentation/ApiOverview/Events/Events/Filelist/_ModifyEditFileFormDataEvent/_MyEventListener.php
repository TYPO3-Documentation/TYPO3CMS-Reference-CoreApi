<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\FileList\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Filelist\Event\ModifyEditFileFormDataEvent;

#[AsEventListener(
    identifier: 'my-extension/modify-edit-file-form-data',
)]
final readonly class MyEventListener
{
    public function __invoke(ModifyEditFileFormDataEvent $event): void
    {
        // Get current form data
        $formData = $event->getFormData();

        // Change TCA "renderType" based on the file extension
        $fileExtension = $event->getFile()->getExtension();
        if ($fileExtension === 'ts') {
            $formData['processedTca']['columns']['data']['config']['renderType'] = 'tsRenderer';
        }

        // Set updated form data
        $event->setFormData($formData);
    }
}
