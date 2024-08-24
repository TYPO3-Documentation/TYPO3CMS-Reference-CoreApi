<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Middleware;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ExampleMiddleware implements MiddlewareInterface
{
    public function __construct(
        private readonly ResponseFactoryInterface $responseFactory,
        private readonly RequestFactoryInterface $requestFactory,
        private readonly ClientInterface $client,
    ) {}

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if ($request->getRequestTarget() === '/example') {
            $req = $this->requestFactory->createRequest('GET', 'https://api.external.app/endpoint.json');
            // Perform HTTP request
            $res = $this->client->sendRequest($req);
            // Process data
            $data = [
                'content' => json_decode((string)$res->getBody()),
            ];
            $response = $this->responseFactory->createResponse()
                ->withHeader('Content-Type', 'application/json; charset=utf-8');
            $response->getBody()->write(json_encode($data));
            return $response;
        }
        return $handler->handle($request);
    }
}
