<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Controller;

use MyVendor\MyExtension\Domain\Repository\ConferenceRepository;
use MyVendor\MyExtension\Validation\Validator\LogoDimensionsValidator;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Mvc\Controller\FileUploadConfiguration;

class ConferenceController extends ActionController
{
    public function __construct(
        protected readonly ConferenceRepository $conferenceRepository,
    ) {}

    public function initializeCreateAction(): void
    {
        $logoValidator = GeneralUtility::makeInstance(LogoDimensionsValidator::class);

        $fileHandlingServiceConfiguration = $this->arguments
            ->getArgument('conference')
            ->getFileHandlingServiceConfiguration();

        $fileHandlingServiceConfiguration->addFileUploadConfiguration(
            (new FileUploadConfiguration('logo'))
                ->setMaxFiles(1)
                ->addValidator($logoValidator)
                ->setUploadFolder('1:/user_upload/conference_logos/'),
        );

        $this->arguments->getArgument('conference')
            ->getPropertyMappingConfiguration()
            ->skipProperties('logo');
    }
}
