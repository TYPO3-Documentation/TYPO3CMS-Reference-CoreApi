<?php
declare(strict_types = 1);

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Mvc\Controller\FileUploadConfiguration;
use TYPO3\CMS\Extbase\Validation\Validator\MimeTypeValidator;

class SomeController extends ActionController
{
    public function initializeCreateAction(): void
    {
        // As Validators can contain state do not inject them
        $mimeTypeValidator = GeneralUtility::makeInstance(MimeTypeValidator::class);
        $mimeTypeValidator->setOptions(['allowedMimeTypes' => ['image/jpeg']]);

        $fileHandlingServiceConfiguration = $this->arguments->getArgument('myArgument')->getFileHandlingServiceConfiguration();
        $fileHandlingServiceConfiguration->addFileUploadConfiguration(
            (new FileUploadConfiguration('myPropertyName'))
                ->setRequired()
                ->addValidator($mimeTypeValidator)
                ->setMaxFiles(1)
                ->setUploadFolder('1:/user_upload/files/')
        );

        $this->arguments->getArgument('myArgument')->getPropertyMappingConfiguration()->skipProperties('myPropertyName');
    }
}
