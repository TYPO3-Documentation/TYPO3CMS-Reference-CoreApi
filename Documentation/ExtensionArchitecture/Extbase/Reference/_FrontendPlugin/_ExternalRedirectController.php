<?php

use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

final class MyController extends ActionController
{
    public function downloadAction(): ResponseInterface
    {
        // ... do something (set $value, ...)

        $uri = $this->uriBuilder->uriFor('show', ['parameter' => $value]);

        // $uri could also be https://example.com/any/uri
        return $this->responseFactory->createResponse(307)
            ->withHeader('Location', $uri);
    }
}
