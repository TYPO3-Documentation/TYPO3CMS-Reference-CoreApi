<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Model;

use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class Blog extends AbstractEntity
{
    // A single file
    protected ?FileReference $singleFile = null;

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

    // For later examples, the setters:
    public function setSingleFile(?FileReference $singleFile): void
    {
        $this->singleFile = $singleFile;
    }

    public function setMultipleFiles(ObjectStorage $files): void
    {
        $this->multipleFiles = $files;
    }
}
