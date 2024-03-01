<?php

use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Http\PropagateResponseException;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

// Example by: https://brot.krue.ml/extbase-controller-action-responses-in-typo3/
final class MyController extends ActionController
{
    public function downloadAction(): ResponseInterface
    {
        // ... do something (set $filename, $filePath, ...)

        $response = $this->responseFactory->createResponse()
            ->withHeader('Cache-Control', 'private')
            ->withHeader('Content-Disposition', sprintf('attachment; filename="%s"', $filename))
            ->withHeader('Content-Length', (string)filesize($filePath))
            ->withHeader('Content-Type', 'application/pdf')
            ->withBody($this->streamFactory->createStreamFromFile($filePath));

        throw new PropagateResponseException($response, 200);
    }
}
