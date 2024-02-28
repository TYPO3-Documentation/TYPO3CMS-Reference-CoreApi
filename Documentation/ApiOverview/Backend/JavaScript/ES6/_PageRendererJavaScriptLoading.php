<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\SomeNamespace;

use TYPO3\CMS\Core\Page\JavaScriptModuleInstruction;
use TYPO3\CMS\Core\Page\PageRenderer;

final class SomeClass
{
    public function __construct(
        // Inject the page renderer dependency
        private readonly PageRenderer $pageRenderer,
    ) {}

    public function someFunction()
    {
        // Load JavaScript via PageRenderer
        $this->pageRenderer->loadJavaScriptModule('@vendor/my-extension/example.js');

        // Load JavaScript via JavaScriptRenderer
        $this->pageRenderer->getJavaScriptRenderer()->addJavaScriptModuleInstruction(
            JavaScriptModuleInstruction::create('@vendor/my-extension/example.js'),
        );
    }
}
