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
   * language original, leaving out those that exist without a default
   * language parent. The aspect is built here, for a language without a
   * fallback chain, rather than derived from a site language.
   */
  public function translatedOnlyAction(int $languageId): ResponseInterface
  {
    $languageAspect = new LanguageAspect(
      $languageId, // language id
      $languageId, // content id
      LanguageAspect::OVERLAYS_ON_WITH_FLOATING,
      [],
    );

    $this->view->assign(
      'conferences',
      $this->conferenceRepository->findTranslationsForLanguageAspect($languageAspect),
    );
    return $this->htmlResponse();
  }
}
