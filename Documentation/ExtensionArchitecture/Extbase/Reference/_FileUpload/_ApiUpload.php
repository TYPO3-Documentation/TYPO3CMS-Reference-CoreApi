<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Controller;

use MyVendor\MyExtension\Domain\Model\Blog;
use MyVendor\MyExtension\Domain\Repository\BlogRepository;
use TYPO3\CMS\Core\Resource\Enum\DuplicationBehavior;
use TYPO3\CMS\Core\Resource\ResourceFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\StringUtility;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class BlogController extends ActionController
{
    public function __construct(
        protected ResourceFactory $resourceFactory,
        protected BlogRepository $blogRepository,
    ) {}

    public function attachFileUpload(Blog $blog): void
    {
        $falIdentifier = '1:/your_storage';
        $yourFile = '/path/to/uploaded/file.jpg';

        // Attach the file to the wanted storage
        $falFolder = $this->resourceFactory->retrieveFileOrFolderObject($falIdentifier);
        $fileObject = $falFolder->addFile(
            $yourFile,
            basename($yourFile),
            DuplicationBehavior::REPLACE,
        );

        // Initialize a new storage object
        $newObject = [
            'uid_local' => $fileObject->getUid(),
            'uid_foreign' => StringUtility::getUniqueId('NEW'),
            'uid' => StringUtility::getUniqueId('NEW'),
            'crop' => null,
        ];

        // Create the FileReference Object
        $fileReference = $this->resourceFactory->createFileReferenceObject($newObject);

        // Port the FileReference Object to an Extbase FileReference
        $fileReferenceObject = GeneralUtility::makeInstance(FileReference::class);
        $fileReferenceObject->setOriginalResource($fileReference);

        // Persist the created file reference object to our Blog model
        $blog->setSingleFile($fileReferenceObject);
        $this->blogRepository->update($blog);

        // Note: For multiple files, a wrapping ObjectStorage would be needed
    }
}
