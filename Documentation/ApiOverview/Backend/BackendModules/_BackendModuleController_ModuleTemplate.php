<?php

declare(strict_types=1);

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Backend\Template\ModuleTemplate;
use TYPO3\CMS\Backend\Template\ModuleTemplateFactory;
use TYPO3\CMS\Core\Localization\LanguageService;
use TYPO3\CMS\Core\Type\ContextualFeedbackSeverity;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

final class BackendModuleController extends ActionController
{
    public function __construct(
        private readonly ModuleTemplateFactory $moduleTemplateFactory,
        // ..
    ) {}

    private function initializeModuleTemplate(ServerRequestInterface $request): ModuleTemplate
    {
        $moduleTemplate = $this->moduleTemplateFactory->create($request);
        // Add common buttons and menues

        $buttonBar = $moduleTemplate->getDocHeaderComponent()->getButtonBar();
        $this->addButtonsToBar($buttonBar);

        $menu = $moduleTemplate->getDocHeaderComponent()->getMenuRegistry()->makeMenu();
        $menu = $this->addMenuItems($menu);
        $moduleTemplate->getDocHeaderComponent()->getMenuRegistry()->addMenu($menu);

        // Add menu items

        return $moduleTemplate;
    }

    private function getLanguageService(): LanguageService
    {
        return $GLOBALS['LANG'];
    }

    private function addButtonsToBar(\TYPO3\CMS\Backend\Template\Components\ButtonBar $buttonBar): void
    {
        // TODO: Add buttons to bar
    }

    private function addMenuItems(\TYPO3\CMS\Backend\Template\Components\Menu\Menu $menu): \TYPO3\CMS\Backend\Template\Components\Menu\Menu
    {
        // TODO: Add menu items
        return $menu;
    }

    public function someAction(): ResponseInterface
    {
        $moduleTemplate = $this->initializeModuleTemplate($this->request);

        // Add a flash message
        $moduleTemplate->addFlashMessage('Everything is fine', 'Info', ContextualFeedbackSeverity::INFO);

        // Assign variables to the template
        $moduleTemplate->assignMultiple([
            'variable1' => 'value 1',
            'variable2' => 'value 2',
        ]);
        return $moduleTemplate->renderResponse('Backend/Some');
    }

}
