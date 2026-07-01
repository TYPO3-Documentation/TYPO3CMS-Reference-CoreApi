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

    public function createAction(Conference $conference): ResponseInterface
    {
        $this->conferenceRepository->add($conference);

        // Force the write now: the redirect below ends the request before the
        // automatic flush, and we need the new UID for the show action.
        $this->persistenceManager->persistAll();

        return $this->redirect('show', null, null, ['conference' => $conference->getUid()]);
    }
}
