<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Middleware;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class MyLaterMiddleware implements MiddlewareInterface
{
    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        // Get the attribute
        $cacheInstruction = $request->getAttribute('frontend.cache.instruction');

        // Disable the cache and give a reason
        $cacheInstruction->disableCache('EXT:my-extension: My-reason disables caches.');

        // ... more logic

        return $handler->handle($request);
    }
}
