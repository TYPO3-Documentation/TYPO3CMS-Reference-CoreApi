<?php

declare(strict_types=1);

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
    $this->persistenceManager->persistAll();
    $uid = $conference->getUid();
    return $this->redirect('show', null, null, ['conference' => $uid]);
  }
}
