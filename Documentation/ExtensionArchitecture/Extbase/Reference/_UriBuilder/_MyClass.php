<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\MyClass;

use TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder;

final class MyClass
{
    private UriBuilder $uriBuilder;

    public function __construct(UriBuilder $uriBuilder)
    {
        $this->uriBuilder = $uriBuilder;
    }

    public function doSomething()
    {
        $url = $this->uriBuilder
            ->reset()
            ->setTargetPageUid(42)
            ->uriFor(
                'myAction',
                [
                    'myRecord' => 21,
                ],
                'MyController',
                'myextension',
                'myplugin'
            );

        // do something with $url
    }
}
