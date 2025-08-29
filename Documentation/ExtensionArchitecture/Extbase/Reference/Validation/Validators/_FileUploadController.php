<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Mvc\Controller\FileUploadConfiguration;
use TYPO3\CMS\Extbase\Validation\Validator\FileExtensionValidator;
use TYPO3\CMS\Extbase\Validation\Validator\MimeTypeValidator;

class SomeController extends ActionController
{
    public function initializeCreateAction(): void
    {
        // As Validators can contain state, do not inject them
        $mimeTypeValidator = GeneralUtility::makeInstance(MimeTypeValidator::class);
        $mimeTypeValidator->setOptions([
            'allowedMimeTypes' => ['image/jpeg'],
            'ignoreFileExtensionCheck' => false,
            'notAllowedMessage' => 'LLL:EXT:my_extension/...',
            'invalidExtensionMessage' => 'LLL:EXT:my_extension/...',
        ]);

        $fileExtensionValidator = GeneralUtility::makeInstance(FileExtensionValidator::class);
        $fileExtensionValidator->setOptions([
            'allowedFileExtensions' => ['jpg', 'jpeg'],
        ]);

        $fileHandlingServiceConfiguration = $this->arguments->getArgument('myArgument')->getFileHandlingServiceConfiguration();
        $fileHandlingServiceConfiguration->addFileUploadConfiguration(
            (new FileUploadConfiguration('myPropertyName'))
                ->setRequired()
                ->addValidator($mimeTypeValidator)
                ->addValidator($fileExtensionValidator)
                ->setMaxFiles(1)
                ->setUploadFolder('1:/user_upload/files/'),
        );

        // Extbase's property mapping is not handling FileUploads, so it must not operate on this property.
        // When using the FileUpload attribute/annotation, this internally does the same. This is covered
        // by the `addFileUploadConfiguration()` functionality.
        $this->arguments->getArgument('myArgument')->getPropertyMappingConfiguration()->skipProperties('myPropertyName');
    }
}
