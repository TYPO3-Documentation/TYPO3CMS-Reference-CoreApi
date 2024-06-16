<?php

namespace MyVendor\MyExtension\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;
use TYPO3\CMS\Backend\Routing\UriBuilder;
use TYPO3\CMS\Backend\Template\ModuleTemplate;
use TYPO3\CMS\Backend\Template\ModuleTemplateFactory;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class ModuleController extends ActionController
{
    public function __construct(
        protected readonly ModuleTemplateFactory $moduleTemplateFactory,
        private readonly UriBuilder $backendUriBuilder,
    ) {}

    protected function getEditLink(): UriInterface
    {
        $uriParameters = [
            'edit' =>
                [
                    'pages' => [1 => 'edit'],
                ],
        ];
        return $this->backendUriBuilder
            ->buildUriFromRoute('record_edit', $uriParameters);
    }

    public function linksAction(): ResponseInterface
    {
        $backendView = $this->initializeModuleTemplate($this->request);
        $editPage1Link = $this->getEditLink();
        $backendView->assignMultiple(
            [
                'editPage1Link' => $editPage1Link,
            ],
        );
        return $backendView->renderResponse('ShowPost');
    }
    protected function initializeModuleTemplate(
        ServerRequestInterface $request,
    ): ModuleTemplate {
        $view = $this->moduleTemplateFactory->create($request);

        // ...

        return $view;
    }
}
