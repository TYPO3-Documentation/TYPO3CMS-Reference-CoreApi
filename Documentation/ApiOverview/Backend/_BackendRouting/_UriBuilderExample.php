<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Backend\Routing\UriBuilder;

final class MyRouteController
{
    public function __construct(
        private readonly UriBuilder $uriBuilder
    ) {}

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        // ... do some stuff

        // Using a route identifier
        $uri = $this->uriBuilder->buildUriFromRoute(
            'web_layout',
            ['id' => 42]
        );

        // Using a route path
        $uri = $this->uriBuilder->buildUriFromRoutePath(
            '/record/edit',
            [
                'edit' => [
                    'pages' => [
                        123 => 'edit',
                    ],
                ],
            ]
        );

        // Using a PSR-7 request object
        // This is typically useful when linking to the current route or module
        // in the TYPO3 backend to avoid internals with any PSR-7 request attribute.
        $uri = $this->uriBuilder->buildUriFromRequest($request, ['id' => 42]);

        // ... do some other stuff
    }
}
