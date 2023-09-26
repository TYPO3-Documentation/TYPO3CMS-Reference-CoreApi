<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ExampleController
{
    public function doSomethingAction(ServerRequestInterface $request): ResponseInterface
    {
        $input = $request->getQueryParams()['input']
            ?? throw new \InvalidArgumentException(
                'Please provide a number',
                1580585107
            );

        $result = $input ** 2;

        // TODO: return ResponseInterface
    }
}
