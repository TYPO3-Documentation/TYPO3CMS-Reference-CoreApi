<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Model;

use TYPO3\CMS\Core\Resource\Enum\DuplicationBehavior;
use TYPO3\CMS\Extbase\Attribute\FileUpload;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class Blog extends AbstractEntity
{
    // A single file
    #[FileUpload(
        validation: [
            'required' => true,
            'maxFiles' => 1,
            'fileSize' => ['minimum' => '0K', 'maximum' => '2M'],
            'mimeType' => [
                'allowedMimeTypes' => ['image/jpeg'],
                'ignoreFileExtensionCheck' => false,
                'notAllowedMessage' => 'LLL:EXT:my_extension/...',
                'invalidExtensionMessage' => 'LLL:EXT:my_extension/...',
            ],
            'imageDimensions' => ['maxWidth' => 4096, 'maxHeight' => 4096],
        ],
        uploadFolder: '1:/user_upload/extbase_single_file/',
        addRandomSuffix: true,
        duplicationBehavior: DuplicationBehavior::RENAME,
    )]
    protected ?FileReference $singleFile = null;

    #[FileUpload(
        validation: [
            'required' => true,
            'fileSize' => ['minimum' => '0K', 'maximum' => '2M'],
            'mimeType' => [
                'allowedMimeTypes' => ['image/jpeg'],
                'ignoreFileExtensionCheck' => false,
                'notAllowedMessage' => 'LLL:EXT:my_extension/...',
                'invalidExtensionMessage' => 'LLL:EXT:my_extension/...',
            ],
        ],
        uploadFolder: '1:/user_upload/extbase_multiple_files/',
    )]
    /**
     * A collection of files.
     * @var ObjectStorage<FileReference>
     */
    protected ObjectStorage $multipleFiles;

    public function __construct()
    {
        $this->multipleFiles = new ObjectStorage();
    }

    public function initializeObject(): void
    {
        $this->multipleFiles = $this->multipleFiles ?? new ObjectStorage();
    }

    public function getSingleFile(): ?FileReference
    {
        return $this->singleFile;
    }

    /**
     * @return ObjectStorage|FileReference[]
     */
    public function getMultipleFiles(): ObjectStorage
    {
        return $this->multipleFiles;
    }

    public function setSingleFile(?FileReference $singleFile): void
    {
        $this->singleFile = $singleFile;
    }

    public function setMultipleFiles(ObjectStorage $files): void
    {
        $this->multipleFiles = $files;
    }
}
