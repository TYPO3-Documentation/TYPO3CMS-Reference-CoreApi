<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Controller;

use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Mvc\View\JsonView;

class ConferenceController extends ActionController
{
  protected ?string $defaultViewObjectName = JsonView::class;

  public function listAction(): ResponseInterface
  {
    $this->view->assign('conferences', $this->conferenceRepository->findAll());
    $this->view->setVariablesToRender(['conferences']);
    $this->view->setConfiguration([
      'conferences' => [
        '_descendAll' => [
          '_only' => ['title', 'conferenceDate', 'uid'],
        ],
      ],
    ]);
    return $this->jsonResponse();
  }
}
