<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Hooks;

use TYPO3\CMS\Core\Page\PageRenderer;

final class BackendControllerHook
{
    private PageRenderer $pageRenderer;

    public function __construct(PageRenderer $pageRenderer)
    {
        $this->pageRenderer = $pageRenderer;
    }

    public function registerClientSideEventHandler(): void
    {
        $this->pageRenderer->loadJavaScriptModule(
            '@myvendor/my-extension/event-handler.js'
        );
        $this->pageRenderer->addInlineLanguageLabelFile(
            'EXT:my_extension/Resources/Private/Language/locallang_slug_service.xlf'
        );
    }
}
