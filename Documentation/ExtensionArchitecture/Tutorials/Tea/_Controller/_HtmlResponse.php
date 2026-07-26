<?php

use Psr\Http\Message\ResponseInterface;

abstract class ActionController implements ControllerInterface
{
    protected function htmlResponse(string $html = null): ResponseInterface
    {
        return $this->responseFactory->createResponse()
            ->withHeader('Content-Type', 'text/html; charset=utf-8')
            ->withBody($this->streamFactory->createStream(($html ?? $this->view->render())));
    }
}
