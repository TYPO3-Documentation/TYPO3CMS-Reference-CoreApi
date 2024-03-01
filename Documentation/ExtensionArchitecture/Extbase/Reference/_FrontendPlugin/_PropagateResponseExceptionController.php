<?php

use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Http\PropagateResponseException;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

final class MyController extends ActionController
{
    public function downloadAction(): ResponseInterface
    {
        // ... do something (set $filename, $filePath, ...)

        $response = $this->responseFactory->createResponse()
            // Must not be cached by a shared cache, such as a proxy server
            ->withHeader('Cache-Control', 'private')
            // Should be downloaded with the given filename
            ->withHeader('Content-Disposition', sprintf('attachment; filename="%s"', $filename))
            ->withHeader('Content-Length', (string)filesize($filePath))
            // It is a PDF file we provide as a download
            ->withHeader('Content-Type', 'application/pdf')
            ->withBody($this->streamFactory->createStreamFromFile($filePath));

        throw new PropagateResponseException($response, 200);
    }
}
