<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\MyClass;

use TYPO3\CMS\Core\Page\AssetCollector;

final class MyClass
{
    private AssetCollector $assetCollector;

    public function __construct(AssetCollector $assetCollector) {
        $this->assetCollector = $assetCollector;
    }

    public function doSomething()
    {
        // $this->assetCollector can now be used
        // see examples below
    }
}
