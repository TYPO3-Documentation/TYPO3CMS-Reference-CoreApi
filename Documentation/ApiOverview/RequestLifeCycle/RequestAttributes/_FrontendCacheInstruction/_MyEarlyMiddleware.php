<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Middleware;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TYPO3\CMS\Frontend\Cache\CacheInstruction;

final class MyEarlyMiddleware implements MiddlewareInterface
{
    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        // Get the attribute, if not available, use a new CacheInstruction object
        $cacheInstruction = $request->getAttribute(
            'frontend.cache.instruction',
            new CacheInstruction(),
        );

        // Disable the cache and give a reason
        $cacheInstruction->disableCache('EXT:my-extension: My-reason disables caches.');

        // Write back the cache instruction to the attribute
        $request = $request->withAttribute('frontend.cache.instruction', $cacheInstruction);

        // ... more logic

        return $handler->handle($request);
    }
}
