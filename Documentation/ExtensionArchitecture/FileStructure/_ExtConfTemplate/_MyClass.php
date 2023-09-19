<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\MyClass;

use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;

final class MyClass
{
    public function __construct(
        private readonly ExtensionConfiguration $extensionConfiguration
    ) {}

    public function doSomething()
    {
        // ...

        $myConfiguration = $this->extensionConfiguration
            ->get('my_extension_key');

        // ...
    }
}
