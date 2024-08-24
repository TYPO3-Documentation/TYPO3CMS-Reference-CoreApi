<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Middleware;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TYPO3\CMS\Core\Routing\RouterInterface;

class RequestEnrichingMiddleware implements MiddlewareInterface {


    public function __construct(
        private readonly RouterInterface $matcher
    ){}

    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface
    {
        $routeResult = $this->matcher->matchRequest($request);

        $request = $request->withAttribute('site', $routeResult->getSite());
        $request = $request->withAttribute('language', $routeResult->getLanguage());

        return $handler->handle($request);
    }
}
