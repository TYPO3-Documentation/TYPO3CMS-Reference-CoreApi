<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Backend\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Page\JavaScriptModuleInstruction;
use TYPO3\CMS\Core\Page\PageRenderer;

final class SomeController
{
    public function __construct(private readonly PageRenderer $pageRenderer) {}

    public function mainAction(ServerRequestInterface $request): ResponseInterface
    {
        $javaScriptRenderer = $this->pageRenderer->getJavaScriptRenderer();
        $javaScriptRenderer->addJavaScriptModuleInstruction(
            JavaScriptModuleInstruction::create('@myvendor/my_extension/my-service.js')
                ->invoke('someFunction')
        );
        // ...
        return $this->pageRenderer->renderResponse();
    }
}
