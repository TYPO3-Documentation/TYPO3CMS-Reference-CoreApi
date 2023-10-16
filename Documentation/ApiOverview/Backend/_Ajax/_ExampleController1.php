<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ExampleController
{
    public function doSomethingAction(ServerRequestInterface $request): ResponseInterface
    {
        // TODO: return ResponseInterface
    }
}
