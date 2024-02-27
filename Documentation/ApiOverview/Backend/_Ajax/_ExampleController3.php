<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Controller;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ExampleController
{
    public function __construct(
        private readonly ResponseFactoryInterface $responseFactory
    ) {}

    public function doSomethingAction(ServerRequestInterface $request): ResponseInterface
    {
        $input = $request->getQueryParams()['input']
            ?? throw new \InvalidArgumentException(
                'Please provide a number',
                1580585107
            );

        $result = $input ** 2;

        $response = $this->responseFactory->createResponse()
            ->withHeader('Content-Type', 'application/json; charset=utf-8');
        $response->getBody()->write(
            json_encode(['result' => $result], JSON_THROW_ON_ERROR)
        );
        return $response;
    }
}
