<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Controller;

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
    $this->view->assign(
      'conferences',
      $this->conferenceRepository->findAll(),
    );
    return $this->htmlResponse();
  }
}
