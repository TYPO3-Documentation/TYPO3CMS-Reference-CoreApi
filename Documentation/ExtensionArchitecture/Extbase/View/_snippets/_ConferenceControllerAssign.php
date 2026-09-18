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

  public function listAction(): ResponseInterface
  {
    $this->view->assign('conferences', $this->conferenceRepository->findAll());
    $this->view->assign('title', 'Upcoming conferences');
    return $this->htmlResponse();
  }

  public function showAction(Conference $conference): ResponseInterface
  {
    $this->view->assignMultiple([
      'conference' => $conference,
      'speakers' => $conference->getSpeakers(),
    ]);
    return $this->htmlResponse();
  }
}
