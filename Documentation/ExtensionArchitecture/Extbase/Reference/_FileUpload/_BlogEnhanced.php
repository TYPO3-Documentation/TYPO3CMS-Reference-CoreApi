<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Model;

use TYPO3\CMS\Core\Resource\Enum\DuplicationBehavior;
use TYPO3\CMS\Extbase\Annotation\FileUpload;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class Blog extends AbstractEntity
{
    // A single file
    #[FileUpload([
        'validation' => [
            'required' => true,
            'maxFiles' => 1,
            'fileSize' => ['minimum' => '0K', 'maximum' => '2M'],
            'allowedMimeTypes' => ['image/jpeg'],
            'imageDimensions' => ['maxWidth' => 4096, 'maxHeight' => 4096],
        ],
        'uploadFolder' => '1:/user_upload/extbase_single_file/',
        'addRandomSuffix' => true,
        'duplicationBehavior' => DuplicationBehavior::RENAME,
    ])]
    protected ?FileReference $singleFile = null;

    #[FileUpload([
        'validation' => [
            'required' => true,
            'fileSize' => ['minimum' => '0K', 'maximum' => '2M'],
            'allowedMimeTypes' => ['image/jpeg'],
        ],
        'uploadFolder' => '1:/user_upload/extbase_single_file/',
    ])]
    /**
     * A collection of files.
     * @var ObjectStorage<FileReference>
     */
    protected ObjectStorage $multipleFiles;

    // When using ObjectStorages, it is vital to initialize these.
    public function __construct()
    {
        $this->initializeObjectStorage();
    }

    public function initializeObjectStorage(): void
    {
        $this->multipleFiles = new ObjectStorage();
    }

    // Typical getters
    public function getSingleFile(): ?FileReference
    {
        return $this->singleFile;
    }

    public function getMultipleFiles(): ObjectStorage
    {
        return $this->multipleFiles;
    }

    // Typical setters
    public function setSingleFile(?FileReference $singleFile): void
    {
        $this->singleFile = $singleFile;
    }

    public function setMultipleFiles(ObjectStorage $files): void
    {
        $this->multipleFiles = $files;
    }
}
