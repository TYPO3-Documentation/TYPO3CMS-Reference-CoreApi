<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Hooks;

use TYPO3\CMS\Core\Page\PageRenderer;

final class BackendControllerHook
{
    public function __construct(
        private readonly PageRenderer $pageRenderer,
    ) {}

    public function registerClientSideEventHandler(): void
    {
        $this->pageRenderer->loadJavaScriptModule(
            '@myvendor/my-extension/event-handler.js',
        );
        $this->pageRenderer->addInlineLanguageDomain(
                'my_extension.slug_service'
        );
    }
}
