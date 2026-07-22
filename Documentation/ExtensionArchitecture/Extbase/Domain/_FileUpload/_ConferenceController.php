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

    public function newAction(): ResponseInterface
    {
        $this->view->assign('conference', new Conference());
        return $this->htmlResponse();
    }

    public function createAction(Conference $conference): ResponseInterface
    {
        $this->conferenceRepository->add($conference);
        return $this->redirect('list');
    }

    public function editAction(Conference $conference): ResponseInterface
    {
        $this->view->assign('conference', $conference);
        return $this->htmlResponse();
    }

    public function updateAction(Conference $conference): ResponseInterface
    {
        $this->conferenceRepository->update($conference);
        return $this->redirect('list');
    }
}
