<?php

namespace MyVendor\MyExtension\Controller;

use MyVendor\MyExtension\Domain\Model\Conference;
use MyVendor\MyExtension\Domain\Repository\ConferenceRepository;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface;

class ConferenceController extends ActionController
{
    public function __construct(
        protected readonly ConferenceRepository $conferenceRepository,
        protected readonly PersistenceManagerInterface $persistenceManager,
    ) {}

    public function saveAction(Conference $conference): ResponseInterface
    {
        if ($this->persistenceManager->isNewObject($conference)) {
            $this->conferenceRepository->add($conference);
        } else {
            $this->conferenceRepository->update($conference);
        }

        return $this->redirect('list');
    }
}
