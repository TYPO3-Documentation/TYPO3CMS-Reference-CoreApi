<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class RequestEnrichingMiddleware implements MiddlewareInterface
{
    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler,
    ): ResponseInterface {
        $response = $handler->handle($request);

        if ($request->getRequestTarget() === 'foo/bar') {
            $response = $response->withHeader(
                'Content-Length',
                (string)$response->getBody()->getSize(),
            );
        }

        return $response;
    }
}
