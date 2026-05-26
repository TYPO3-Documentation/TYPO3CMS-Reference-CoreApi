<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Controller;

use MyVendor\MyExtension\Domain\Model\Conference;
use MyVendor\MyExtension\Domain\Repository\ConferenceRepository;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class ConferenceController extends ActionController
{
    public function __construct(
        protected readonly ConferenceRepository $conferenceRepository,
    ) {}

    public function initializeCreateAction(): void
    {
        $this->arguments['conference']
            ->getPropertyMappingConfiguration()
            ->allowProperties('title', 'conferenceDate');
    }

    public function createAction(Conference $conference): ResponseInterface
    {
        $this->conferenceRepository->add($conference);
        return $this->redirect('list');
    }
}
