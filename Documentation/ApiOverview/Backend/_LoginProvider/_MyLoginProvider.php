<?php

namespace MyVendor\MyExtension\Login;

use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\DependencyInjection\Attribute\Autoconfigure;
use TYPO3\CMS\Backend\LoginProvider\LoginProviderInterface;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\View\ViewInterface;
use TYPO3\CMS\Fluid\View\FluidViewAdapter;

#[Autoconfigure(public: true)]
final readonly class MyLoginProvider implements LoginProviderInterface
{
    public function __construct(
        private PageRenderer $pageRenderer,
    ) {}

    public function modifyView(ServerRequestInterface $request, ViewInterface $view): string
    {
        $this->pageRenderer->addJsFile('someFile');
        // Custom login provider implementations can add custom fluid lookup paths.
        if ($view instanceof FluidViewAdapter) {
            $templatePaths = $view->getRenderingContext()->getTemplatePaths();
            $templateRootPaths = $templatePaths->getTemplateRootPaths();
            $templateRootPaths[] = 'EXT:my_extension/Resources/Private/Templates';
            $templatePaths->setTemplateRootPaths($templateRootPaths);
        }
        $view->assign('Some Variable', 'some value');
        return 'Login/MyLoginForm';
    }
}
