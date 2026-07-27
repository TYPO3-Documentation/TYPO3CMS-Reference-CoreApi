<?php

use Psr\Http\Message\ResponseInterface;

class BlogController extends AbstractController
{
    /**
     * Output <h1>Hello World!</h1>
     */
    public function helloWorldAction(): ResponseInterface
    {
        return $this->htmlResponse('<h1>Hello World!</h1>');
    }
}
