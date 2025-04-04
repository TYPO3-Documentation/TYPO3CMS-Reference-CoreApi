<?php

declare(strict_types=1);

use TYPO3\CMS\Extbase\Annotation\FileUpload;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;

class SomeDto
{
    #[FileUpload([
        'validation' => [
            'required' => true,
            'mimeType' => [
                'allowedMimeTypes' => ['image/jpeg'],
                'ignoreFileExtensionCheck' => false,
                'notAllowedMessage' => 'LLL:EXT:my_extension/...',
                'invalidExtensionMessage' => 'LLL:EXT:my_extension/...',
            ],
        ],
        'uploadFolder' => '1:/user_upload/files/',
    ])]
    protected ?FileReference $file = null;
}
