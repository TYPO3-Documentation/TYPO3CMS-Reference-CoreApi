<?php

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Backend\Template\Components\ButtonBar;
use TYPO3\CMS\Backend\Template\ModuleTemplate;
use TYPO3\CMS\Core\Imaging\IconSize;

final readonly class AdminModuleController
{
    private function setUpDocHeader(
        ServerRequestInterface $request,
        ModuleTemplate $view,
    ): void {
        $buttonBar = $view->getDocHeaderComponent()->getButtonBar();
        $uriBuilderPath = $this->uriBuilder->buildUriFromRoute('web_list', ['id' => 0]);
        $list = $buttonBar->makeLinkButton()
            ->setHref($uriBuilderPath)
            ->setTitle('A Title')
            ->setShowLabelText(true)
            ->setIcon($this->iconFactory->getIcon('actions-extension-import', IconSize::SMALL));
        $buttonBar->addButton($list, ButtonBar::BUTTON_POSITION_LEFT, 1);
    }
}
