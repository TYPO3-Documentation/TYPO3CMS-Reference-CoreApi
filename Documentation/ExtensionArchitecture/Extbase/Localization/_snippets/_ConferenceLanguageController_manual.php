<?php

namespace MyVendor\MyExtension\Controller;

use MyVendor\MyExtension\Domain\Repository\ConferenceRepository;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Context\LanguageAspect;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class ConferenceController extends ActionController
{
  public function __construct(
    protected readonly ConferenceRepository $conferenceRepository,
  ) {}

  /**
   * Lists only genuine translations: conferences that have a default
   * language original, leaving out those that exist without default language parent.
   * No site configuration produces OVERLAYS_ON, so the aspect is built here
   * rather than derived from a site language.
   */
  public function translatedOnlyAction(int $languageId): ResponseInterface
  {
    $languageAspect = new LanguageAspect(
      $languageId, // language id
      $languageId, // content id
      LanguageAspect::OVERLAYS_ON,
      [],
    );

    return $this->htmlResponse($this->view->assign(
      'conferences',
      $this->conferenceRepository->findAllForLanguageAspect($languageAspect),
    )->render());
  }
}
