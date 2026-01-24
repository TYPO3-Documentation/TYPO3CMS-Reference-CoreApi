<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Model;

use TYPO3\CMS\Extbase\Attribute\FileUpload;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class Blog extends AbstractEntity
{
    #[FileUpload(
        validation: [
            'required' => true,
            'maxFiles' => 1,
            'fileSize' => ['minimum' => '0K', 'maximum' => '2M'],
            'mimeType' => [
                'allowedMimeTypes' => ['image/jpeg', 'image/png'],
                'ignoreFileExtensionCheck' => false,
                'notAllowedMessage' => 'LLL:EXT:my_extension/...',
                'invalidExtensionMessage' => 'LLL:EXT:my_extension/...',
            ],
            'fileExtension' => [
                'allowedFileExtensions' => ['jpg', 'jpeg', 'png'],
            ],
        ],
        uploadFolder: '1:/user_upload/files/',
    )]
    protected ?FileReference $file = null;

    // getters and setters like usual
}
