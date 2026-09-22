<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Backend\Routing\UriBuilder;
use TYPO3\CMS\Backend\Template\Components\ComponentFactory;
use TYPO3\CMS\Backend\Template\ModuleTemplate;
use TYPO3\CMS\Backend\Template\ModuleTemplateFactory;
use TYPO3\CMS\Core\Authentication\BackendUserAuthentication;
use TYPO3\CMS\Core\Imaging\IconFactory;
use TYPO3\CMS\Core\Site\Entity\Site;

final readonly class ConferenceController
{
  public function __construct(
    private ModuleTemplateFactory $moduleTemplateFactory,
    private ComponentFactory $componentFactory,
    private IconFactory $iconFactory,
    private UriBuilder $uriBuilder,
  ) {}

  public function handleRequest(
    ServerRequestInterface $request,
  ): ResponseInterface {
    $view = $this->moduleTemplateFactory->create($request);
    $pageId = (int)($request->getQueryParams()['id'] ?? 0);
    $languageId = (int)($request->getQueryParams()['language'] ?? 0);

    // Dropdown of the module's submodules, shown if there are several
    $view->makeDocHeaderModuleMenu(['id' => $pageId]);

    $this->addLanguageSelector($view, $request, $pageId, $languageId);

    return $view->renderResponse('Conference/Index');
  }

  private function addLanguageSelector(
    ModuleTemplate $view,
    ServerRequestInterface $request,
    int $pageId,
    int $activeLanguageId,
  ): void {
    /** @var Site $site */
    $site = $request->getAttribute('site');
    $languageSelector = $this->componentFactory->createDropDownButton()
        ->setLabel('Language')
        ->setShowLabelText(true)
        // Show the selected language as the button text
        ->setShowActiveLabelText(true);

    $languages = $site->getAvailableLanguages(
      $this->getBackendUser(),
      false,
      $pageId,
    );
    foreach ($languages as $language) {
      $url = $this->uriBuilder->buildUriFromRoute(
        'my_extension_conference',
        ['id' => $pageId, 'language' => $language->getLanguageId()],
      );
      $languageSelector->addItem(
        $this->componentFactory->createDropDownRadio()
            ->setHref((string)$url)
            ->setLabel($language->getTitle())
            ->setIcon(
              $this->iconFactory->getIcon($language->getFlagIdentifier()),
            )
            ->setActive($language->getLanguageId() === $activeLanguageId),
      );
    }

    $view->getDocHeaderComponent()->setLanguageSelector($languageSelector);
  }

  private function getBackendUser(): BackendUserAuthentication
  {
    return $GLOBALS['BE_USER'];
  }
}
