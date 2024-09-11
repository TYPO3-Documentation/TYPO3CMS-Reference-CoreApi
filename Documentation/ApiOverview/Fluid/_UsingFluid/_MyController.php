<?php

namespace MyVendor\MyExtension\Controller;

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\View\ViewFactoryData;
use TYPO3\CMS\Core\View\ViewFactoryInterface;

final readonly class MyController
{
    public function __construct(
        private ViewFactoryInterface $viewFactory,
    ) {}

    public function myAction(ServerRequestInterface $request): string
    {
        $viewFactoryData = new ViewFactoryData(
            templateRootPaths: ['EXT:my_extension/Resources/Private/Templates'],
            partialRootPaths: ['EXT:my_extension/Resources/Private/Partials'],
            layoutRootPaths: ['EXT:my_extension/Resources/Private/Layouts'],
            request: $request,
        );
        $view = $this->viewFactory->create($viewFactoryData);
        $view->assign('mykey', 'myValue');
        return $view->render('path/to/template');
    }
}
