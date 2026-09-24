<?php

namespace MyVendor\MyExtension\Controller;

use MyVendor\MyExtension\Domain\Model\Conference;
use MyVendor\MyExtension\Domain\Repository\ConferenceRepository;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Extbase\DomainObject\AbstractDomainObject;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class ConferenceController extends ActionController
{
  public function __construct(
    protected readonly ConferenceRepository $conferenceRepository,
    protected readonly Context $context,
  ) {}

  public function createAction(Conference $conference): ResponseInterface
  {
    $languageId = $this->context
      ->getPropertyFromAspect('language', 'contentId');
    $conference->_setProperty(
      AbstractDomainObject::PROPERTY_LANGUAGE_UID,
      $languageId,
    );

    $this->conferenceRepository->add($conference);

    return $this->redirect('list');
  }
}
