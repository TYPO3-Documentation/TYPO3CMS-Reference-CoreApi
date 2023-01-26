<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\MyClass;

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder;

final class MyClass
{
    public function __construct(
        private readonly UriBuilder $uriBuilder
    ) {
    }

    public function doSomething()
    {
        $this->uriBuilder->setRequest($this->getRequest());

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

    private function getRequest(): ServerRequestInterface
    {
        return $GLOBALS['TYPO3_REQUEST'];
    }
}
