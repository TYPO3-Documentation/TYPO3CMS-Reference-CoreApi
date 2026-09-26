<?php

namespace MyVendor\MyExtension\Controller;

use MyVendor\MyExtension\Domain\Repository\ConferenceRepository;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Backend\Template\ModuleTemplateFactory;
use TYPO3\CMS\Core\Context\LanguageAspectFactory;
use TYPO3\CMS\Core\Site\SiteFinder;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class ConferenceModuleController extends ActionController
{
  public function __construct(
    protected readonly ModuleTemplateFactory $moduleTemplateFactory,
    protected readonly ConferenceRepository $conferenceRepository,
    protected readonly SiteFinder $siteFinder,
  ) {}

  public function indexAction(
    int $pageUid = 0,
    int $languageId = 0,
  ): ResponseInterface {
    // The page selected in the page tree determines the site, and with it
    // the available languages and their fallback configuration.
    $site = $this->siteFinder->getSiteByPageId($pageUid);
    $siteLanguage = $site->getLanguageById($languageId);

    // The same aspect the frontend would use for this site language.
    $languageAspect = LanguageAspectFactory::createFromSiteLanguage(
      $siteLanguage,
    );

    $moduleTemplate = $this->moduleTemplateFactory->create($this->request);
    $moduleTemplate->assign('languages', $site->getLanguages());
    $moduleTemplate->assign('selectedLanguage', $siteLanguage);
    $moduleTemplate->assign(
      'conferences',
      $this->conferenceRepository->findAllForLanguageAspect($languageAspect),
    );

    return $moduleTemplate->renderResponse('Conference/Index');
  }
}
