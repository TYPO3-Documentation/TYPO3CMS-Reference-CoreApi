<?php

declare(strict_types=1);

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Backend\Template\ModuleTemplate;
use TYPO3\CMS\Backend\Template\ModuleTemplateFactory;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

final class BackendModuleController extends ActionController
{
    public function __construct(
        private readonly ModuleTemplateFactory $moduleTemplateFactory,
        // ..
    ) {}

    protected function initializeModuleTemplate(ServerRequestInterface $request): ModuleTemplate
    {
        $moduleTemplate = $this->moduleTemplateFactory->create($request);

        // Add common buttons and menues

        return $moduleTemplate;
    }

    public function someAction(): ResponseInterface
    {
        $moduleTemplate = $this->initializeModuleTemplate($this->request);

        $moduleTemplate->assignMultiple([
            'variable1' => 'value 1',
            'variable2' => 'value 2',
        ]);
        return $moduleTemplate->renderResponse('Backend/Some');
    }

}
