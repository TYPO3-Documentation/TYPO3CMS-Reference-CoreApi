<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\MyClass;

use TYPO3\CMS\Core\Page\AssetCollector;

final class MyClass
{
    public function __construct(
        private readonly AssetCollector $assetCollector,
    ) {}

    public function doSomething()
    {
        // $this->assetCollector can now be used
        // see examples below
    }
}
