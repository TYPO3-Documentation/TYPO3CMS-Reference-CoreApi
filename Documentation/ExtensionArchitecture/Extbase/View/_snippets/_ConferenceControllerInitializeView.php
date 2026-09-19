<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Controller;

use MyVendor\MyExtension\Domain\Model\Conference;
use MyVendor\MyExtension\Domain\Repository\ConferenceRepository;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Site\Entity\Site;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class ConferenceController extends ActionController
{
  public function __construct(
    protected readonly ConferenceRepository $conferenceRepository,
  ) {}

  #[\Override]
  protected function initializeView(): void
  {
    /** @var Site $site */
    $site = $this->request->getAttribute('site');
    $this->view->assign('siteSettings', $site->getSettings()->all());
  }

  public function listAction(): ResponseInterface
  {
    $this->view->assign('conferences', $this->conferenceRepository->findAll());
    return $this->htmlResponse();
  }

  public function showAction(Conference $conference): ResponseInterface
  {
    $this->view->assign('conference', $conference);
    return $this->htmlResponse();
  }
}
