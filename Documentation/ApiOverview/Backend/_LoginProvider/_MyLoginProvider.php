<?php

namespace MyVendor\MyExtension\Login;

use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\DependencyInjection\Attribute\Autoconfigure;
use TYPO3\CMS\Backend\LoginProvider\LoginProviderInterface;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\View\ViewInterface;

#[Autoconfigure(public: true)]
final readonly class MyLoginProvider implements LoginProviderInterface
{
    public function __construct(
        private PageRenderer $pageRenderer,
    ) {}

    public function modifyView(ServerRequestInterface $request, ViewInterface $view): string
    {
        $this->pageRenderer->addJsFile('someFile');
        $view->assign('Some Variable', 'some value');
        return 'Login/MyLoginForm';
    }
}
