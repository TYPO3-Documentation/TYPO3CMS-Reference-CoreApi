<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\MyClass;

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Extbase\Mvc\ExtbaseRequestParameters;
use TYPO3\CMS\Extbase\Mvc\Request;
use TYPO3\CMS\Extbase\Mvc\RequestInterface;
use TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder;

final class MyClass
{
    public function __construct(
        private readonly UriBuilder $uriBuilder,
    ) {}

    public function doSomething()
    {
        $this->uriBuilder->setRequest($this->getExtbaseRequest());

        $url = $this->uriBuilder
            ->reset()
            ->setTargetPageUid(42)
            ->uriFor(
                'my', // only action name, not `myAction`
                [
                    'myRecord' => 21,
                ],
                'My', // only controller name, not `MyController`
                'myextension',
                'myplugin',
            );

        // do something with $url
    }

    private function getExtbaseRequest(): RequestInterface
    {
        /** @var ServerRequestInterface $request */
        $request = $GLOBALS['TYPO3_REQUEST'];

        // We have to provide an Extbase request object
        return new Request(
            $request->withAttribute('extbase', new ExtbaseRequestParameters()),
        );
    }
}
