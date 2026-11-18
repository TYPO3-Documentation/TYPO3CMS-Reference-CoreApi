<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Controller;

use MyVendor\MyExtension\Domain\Repository\ConferenceRepository;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Mvc\View\JsonView;

class ConferenceController extends ActionController
{
  public function __construct(
    protected readonly ConferenceRepository $conferenceRepository,
  ) {}

  protected function initializeUpcomingAction(): void
  {
    $this->defaultViewObjectName = JsonView::class;
  }

  public function upcomingAction(): ResponseInterface
  {
    $conferences = [];
    foreach ($this->conferenceRepository->findUpcoming() as $conference) {
      $conferences[] = [
        'uid' => $conference->getUid(),
        'title' => $conference->getTitle(),
        'conferenceDate' => $conference->getConferenceDate(),
      ];
    }
    $this->view->assignMultiple([
      'conferences' => $conferences,
      'total' => count($conferences),
    ]);
    $this->view->setVariablesToRender(['conferences', 'total']);

    return $this->jsonResponse();
  }
}
