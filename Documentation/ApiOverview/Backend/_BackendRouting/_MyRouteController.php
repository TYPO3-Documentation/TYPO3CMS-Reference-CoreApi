<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class MyRouteController
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $routing = $request->getAttribute('routing');
        $myIdentifier = $routing['identifier'];
        $route = $routing->getRoute();
        // ...
    }
}
