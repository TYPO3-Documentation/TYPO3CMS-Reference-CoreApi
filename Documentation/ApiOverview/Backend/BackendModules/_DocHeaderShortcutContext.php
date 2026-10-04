<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Controller;

use MyVendor\MyExtension\Domain\Repository\ConferenceRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Backend\Template\ModuleTemplateFactory;

final readonly class ConferenceController
{
  public function __construct(
    private ModuleTemplateFactory $moduleTemplateFactory,
    private ConferenceRepository $conferenceRepository,
  ) {}

  public function showAction(
    ServerRequestInterface $request,
  ): ResponseInterface {
    $view = $this->moduleTemplateFactory->create($request);
    $pageId = (int)($request->getQueryParams()['id'] ?? 0);
    $conference = $this->conferenceRepository->findByPageId($pageId);

    // Name the conference, so the bookmark leads back to this one
    $view->getDocHeaderComponent()->setShortcutContext(
      routeIdentifier: 'my_extension_conference',
      displayName: 'Conference: ' . $conference->getTitle(),
      arguments: ['id' => $pageId],
    );

    $view->assign('conference', $conference);

    return $view->renderResponse('Conference/Show');
  }

  public function liveAction(
    ServerRequestInterface $request,
  ): ResponseInterface {
    $view = $this->moduleTemplateFactory->create($request);
    $docHeader = $view->getDocHeaderComponent();

    // This view refreshes itself, and a bookmark of it says nothing
    $docHeader->disableAutomaticReloadButton();
    $docHeader->disableAutomaticShortcutButton();

    return $view->renderResponse('Conference/Live');
  }
}
