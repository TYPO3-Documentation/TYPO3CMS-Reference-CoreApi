<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Annotation\FileUpload;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;

class Blog extends AbstractEntity
{
    #[FileUpload([
        'validation' => [
            'required' => true,
            'maxFiles' => 1,
            'fileSize' => ['minimum' => '0K', 'maximum' => '2M'],
            'allowedMimeTypes' => ['image/jpeg', 'image/png'],
        ],
        'uploadFolder' => '1:/user_upload/files/',
    ])]
    protected ?FileReference $file = null;

    // getters and setters like usual
}
