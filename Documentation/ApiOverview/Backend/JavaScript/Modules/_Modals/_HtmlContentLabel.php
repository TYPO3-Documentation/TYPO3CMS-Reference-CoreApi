<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Controller;

use TYPO3\CMS\Core\Page\PageRenderer;

final class SomeController
{
    public function __construct(
        private readonly PageRenderer $pageRenderer,
    ) {}

    public function someAction(): void
    {
        $this->pageRenderer->loadJavaScriptModule('@my-vendor/my-extension/html-content-modal.js');
        $this->pageRenderer->addInlineLanguageLabel(
            'myExtension.modal.greeting',
            'Hello, %s!',
        );
    }
}
