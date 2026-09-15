<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Service;

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\View\ViewFactoryData;
use TYPO3\CMS\Core\View\ViewFactoryInterface;

readonly class MailService
{
  public function __construct(
    protected ViewFactoryInterface $viewFactory,
  ) {}

  public function renderTemplate(ServerRequestInterface $request): string
  {
    $view = $this->viewFactory->create(new ViewFactoryData(
      templateRootPaths: ['EXT:my_extension/Resources/Private/Templates/'],
      partialRootPaths: ['EXT:my_extension/Resources/Private/Partials/'],
      layoutRootPaths: ['EXT:my_extension/Resources/Private/Layouts/'],
      request: $request,
    ));
    $view->assign('data', $this->loadData());
    return $view->render('Mail/Notification');
  }
}
