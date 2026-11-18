<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Controller;

use MyVendor\MyExtension\Domain\Repository\ConferenceRepository;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Mvc\View\JsonView;

class ConferenceSeatsController extends ActionController
{
  public function __construct(
    protected readonly ConferenceRepository $conferenceRepository,
  ) {}

  protected function initializeSeatsAction(): void
  {
    $this->defaultViewObjectName = JsonView::class;
  }

  public function seatsAction(): ResponseInterface
  {
    $seats = [];
    foreach ($this->conferenceRepository->findUpcoming() as $conference) {
      $seats[] = [
        'uid' => $conference->getUid(),
        'seatsLeft' => $conference->getSeatsLeft(),
      ];
    }
    $this->view->assign('seats', $seats);
    $this->view->setVariablesToRender(['seats']);

    return $this->jsonResponse();
  }
}
