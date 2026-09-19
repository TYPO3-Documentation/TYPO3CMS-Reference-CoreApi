<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Backend\Template\Components\ButtonBar;
use TYPO3\CMS\Backend\Template\Components\ComponentFactory;
use TYPO3\CMS\Backend\Template\ModuleTemplate;
use TYPO3\CMS\Backend\Template\ModuleTemplateFactory;
use TYPO3\CMS\Core\Imaging\IconFactory;

final class MyBackendController
{
  private ModuleTemplate $moduleTemplate;

  public function __construct(
    protected readonly ModuleTemplateFactory $moduleTemplateFactory,
    protected readonly IconFactory $iconFactory,
    protected readonly ComponentFactory $componentFactory,
    // ...
  ) {}

  public function handleRequest(ServerRequestInterface $request): ResponseInterface
  {
    $this->moduleTemplate = $this->moduleTemplateFactory->create($request);
    $this->setDocHeader();
    // ... some more logic
  }

  private function setDocHeader(): void
  {
    $buttonBar = $this->moduleTemplate->getDocHeaderComponent()->getButtonBar();
    $dropDownButton = $this->componentFactory->createDropDownButton()
        ->setLabel('Dropdown')
        ->setTitle('Save')
        ->setIcon($this->iconFactory->getIcon('actions-heart'))
        ->addItem(
          $this->componentFactory->createDropDownItem()
                ->setLabel('Item')
                ->setHref('#'),
        );
    $buttonBar->addButton(
      $dropDownButton,
      ButtonBar::BUTTON_POSITION_RIGHT,
      2,
    );
  }
}
