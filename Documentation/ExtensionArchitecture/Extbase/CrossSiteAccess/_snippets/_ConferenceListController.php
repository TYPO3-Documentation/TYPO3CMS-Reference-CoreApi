<?php

namespace MyVendor\MyExtension\Controller;

use MyVendor\MyExtension\Domain\Repository\ConferenceRepository;
use MyVendor\MyExtension\Service\SharedStorageResolver;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Context\LanguageAspectFactory;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class ConferenceListController extends ActionController
{
  public function __construct(
    protected readonly ConferenceRepository $conferenceRepository,
    protected readonly SharedStorageResolver $sharedStorageResolver,
  ) {}

  public function listAction(): ResponseInterface
  {
    $storageSite = $this->sharedStorageResolver->resolveStorageSite(
      $this->settings['storageSiteIdentifier'],
    );

    // The language the visitor is browsing, in the site being rendered.
    $currentLanguage = $this->request->getAttribute('language');

    $storageLanguage = $this->sharedStorageResolver->resolveStorageLanguage(
      $storageSite,
      $currentLanguage,
    );

    // storage site does not offer the visitor's locale - fall back to storage default language
    $storageLanguage ??= $storageSite->getDefaultLanguage();

    $conferences = $this->conferenceRepository->findAllInStorage(
      $this->settings['storagePageId'],
      LanguageAspectFactory::createFromSiteLanguage($storageLanguage),
    );

    return $this->htmlResponse(
      $this->view->assign('conferences', $conferences)->render(),
    );
  }
}
