<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Controller;

use MyVendor\MyExtension\Domain\Repository\ItemRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Backend\Routing\UriBuilder;
use TYPO3\CMS\Backend\Template\Components\ButtonBar;
use TYPO3\CMS\Backend\Template\Components\Buttons\DropDown\DropDownItem;
use TYPO3\CMS\Backend\Template\Components\ComponentFactory;
use TYPO3\CMS\Backend\Template\ModuleTemplate;
use TYPO3\CMS\Backend\Template\ModuleTemplateFactory;
use TYPO3\CMS\Core\Imaging\IconFactory;

final readonly class MyBackendController
{
  public function __construct(
    private ModuleTemplateFactory $moduleTemplateFactory,
    private ComponentFactory $componentFactory,
    private IconFactory $iconFactory,
    private UriBuilder $uriBuilder,
    private ItemRepository $itemRepository,
  ) {}

  public function handleRequest(
    ServerRequestInterface $request,
  ): ResponseInterface {
    $view = $this->moduleTemplateFactory->create($request);
    $pageId = (int)($request->getQueryParams()['id'] ?? 0);

    $this->addExportButton($view, $pageId);

    return $view->renderResponse('MyBackend/Index');
  }

  private function addExportButton(
    ModuleTemplate $view,
    int $pageId,
  ): void {
    $exportButton = $this->componentFactory->createDropDownButton()
        ->setLabel('Export')
        ->setIcon($this->iconFactory->getIcon('actions-download'))
        // Nothing to export yet: keep the button, but switch it off
        ->setDisabled($this->itemRepository->countByPid($pageId) === 0)
        ->addItem($this->exportItem('CSV', $pageId, 'csv'))
        ->addItem($this->exportItem('XML', $pageId, 'xml'));

    $view->addButtonToButtonBar(
      $exportButton,
      ButtonBar::BUTTON_POSITION_RIGHT,
      2,
    );
  }

  private function exportItem(
    string $label,
    int $pageId,
    string $format,
  ): DropDownItem {
    $url = $this->uriBuilder->buildUriFromRoute(
      'my_extension_export',
      ['id' => $pageId, 'format' => $format],
    );

    return $this->componentFactory->createDropDownItem()
        ->setLabel($label)
        ->setHref((string)$url);
  }
}
