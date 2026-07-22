<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Controller;

use MyVendor\MyExtension\Domain\Model\Conference;
use MyVendor\MyExtension\Domain\Repository\ConferenceRepository;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Type\ContextualFeedbackSeverity;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class ConferenceController extends ActionController
{
    public function __construct(
        protected readonly ConferenceRepository $conferenceRepository,
    ) {}

    public function newAction(?Conference $conference = null): ResponseInterface
    {
        $this->view->assign('conference', $conference ?? new Conference());
        return $this->htmlResponse();
    }

    public function createAction(Conference $conference): ResponseInterface
    {
        $this->conferenceRepository->add($conference);
        $this->addFlashMessage('Conference created.', severity: ContextualFeedbackSeverity::OK);
        return $this->redirect('list');
    }
}
