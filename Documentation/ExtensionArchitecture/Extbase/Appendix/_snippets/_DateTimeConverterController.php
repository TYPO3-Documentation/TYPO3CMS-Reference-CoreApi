<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Controller;

use MyVendor\MyExtension\Domain\Model\Conference;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter;

class ConferenceController extends ActionController
{
    public function initializeCreateAction(): void
    {
        $this->arguments['conference']
            ->getPropertyMappingConfiguration()
            ->forProperty('conferenceDate')
            ->setTypeConverterOption(
                DateTimeConverter::class,
                DateTimeConverter::CONFIGURATION_DATE_FORMAT,
                'd.m.Y',
            );
    }

    public function createAction(Conference $conference): ResponseInterface
    {
        // ...
        return $this->htmlResponse();
    }
}
