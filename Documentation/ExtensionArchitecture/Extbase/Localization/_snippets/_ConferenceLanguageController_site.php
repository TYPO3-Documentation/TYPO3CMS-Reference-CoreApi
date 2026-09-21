<?php

namespace MyVendor\MyExtension\Controller;

use MyVendor\MyExtension\Domain\Repository\ConferenceRepository;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Context\LanguageAspectFactory;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class ConferenceController extends ActionController
{
  public function __construct(
    protected readonly ConferenceRepository $conferenceRepository,
  ) {}

  /**
   * Lists conferences in a chosen language with that language's own
   * translation behaviour.
   */
  public function listInLanguageAction(int $languageId): ResponseInterface
  {
    $site = $this->request->getAttribute('site');
    $languageAspect = LanguageAspectFactory::createFromSiteLanguage(
      $site->getLanguageById($languageId),
    );

    return $this->htmlResponse($this->view->assign(
      'conferences',
      $this->conferenceRepository->findAllForLanguageAspect($languageAspect),
    )->render());
  }
}
