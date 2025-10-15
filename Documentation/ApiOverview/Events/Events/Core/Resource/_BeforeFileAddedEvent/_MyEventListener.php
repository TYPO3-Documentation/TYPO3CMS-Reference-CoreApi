<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Resource\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Core\Resource\Event\BeforeFileAddedEvent;
use TYPO3\CMS\Core\Resource\Exception\UploadSizeException;
use TYPO3\CMS\Core\Utility\GeneralUtility;

#[AsEventListener(
    identifier: 'my-extension/before-file-added',
)]
class BeforeFileAddedEventListener
{
    private const MAX_UPLOAD_SIZE_FOR_PDF = 10 * 1024 * 1024;

    private const MAX_UPLOAD_SIZE_FOR_ZIP = 20 * 1024 * 1024;

    /**
     * @throws UploadSizeException
     */
    public function __invoke(BeforeFileAddedEvent $event): void
    {
        $uploadedFileData = $this->getUploadedFileDataFromGlobalFiles($event->getSourceFilePath());
        if ($uploadedFileData === null) {
            return;
        }

        $uploadedFileSize = $uploadedFileData['size'] ?? 0;
        $uploadedFileExtension = GeneralUtility::split_fileref($uploadedFileData['name'])['fileext'] ?? '';

        if ($uploadedFileExtension === 'pdf' && $uploadedFileSize > self::MAX_UPLOAD_SIZE_FOR_PDF) {
            throw new UploadSizeException('PDF files must not be larger than 10MB.');
        } else if ($uploadedFileExtension === 'zip' && $uploadedFileSize > self::MAX_UPLOAD_SIZE_FOR_ZIP) {
            throw new UploadSizeException('ZIP files must not be larger than 20MB.');
        }
    }

    private function getUploadedFileDataFromGlobalFiles(string $tmpName): ?array
    {
        foreach ($_FILES as $uploadedFileData) {
            if ($uploadedFileData['tmp_name'] === $tmpName) {
                return $uploadedFileData;
            }
        }

        return null;
    }
}
