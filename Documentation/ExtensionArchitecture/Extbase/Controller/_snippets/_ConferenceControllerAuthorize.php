<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Controller;

use MyVendor\MyExtension\Domain\Model\Conference;
use MyVendor\MyExtension\Domain\Repository\ConferenceRepository;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Extbase\Attribute\Authorize;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class ConferenceController extends ActionController
{
    public function __construct(
        protected readonly ConferenceRepository $conferenceRepository,
    ) {}

    public function listAction(): ResponseInterface
    {
        $this->view->assign('conferences', $this->conferenceRepository->findAll());
        return $this->htmlResponse();
    }

    #[Authorize(requireLogin: true)]
    public function newAction(): ResponseInterface
    {
        return $this->htmlResponse();
    }

    #[Authorize(requireLogin: true)]
    public function createAction(Conference $conference): ResponseInterface
    {
        $this->conferenceRepository->add($conference);
        return $this->redirect('list');
    }

    #[Authorize(requireLogin: true, callback: 'isOwner')]
    public function deleteAction(Conference $conference): ResponseInterface
    {
        $this->conferenceRepository->remove($conference);
        return $this->redirect('list');
    }

    public function isOwner(Conference $conference): bool
    {
        $currentUserId = $this->request->getAttribute('frontend.user')?->getUserId();
        return $currentUserId !== null && $conference->getOwnerUid() === $currentUserId;
    }
}
