<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\MyClass;

use TYPO3\CMS\Core\Page\PageRenderer;

final class MyClass
{
    private PageRenderer $pageRenderer;

    public function __construct(PageRenderer $pageRenderer) {
        $this->pageRenderer = $pageRenderer;
    }

    public function doSomething()
    {
        // $this->pageRenderer can now be used
        // see examples below
    }
}
