<?php

declare(strict_types=1);

namespace MyVendor\MySitePackage\Error;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Error\PageErrorHandler\PageErrorHandlerInterface;
use TYPO3\CMS\Core\Http\HtmlResponse;

final class ErrorHandler implements PageErrorHandlerInterface
{
    private int $statusCode;
    private array $errorHandlerConfiguration;

    public function __construct(int $statusCode, array $configuration)
    {
        $this->statusCode = $statusCode;
        // This contains the configuration of the error handler which is
        // set in site configuration - this example does not use it.
        $this->errorHandlerConfiguration = $configuration;
    }

    public function handlePageError(
        ServerRequestInterface $request,
        string $message,
        array $reasons = [],
    ): ResponseInterface {
        return new HtmlResponse('<h1>Not found, sorry</h1>', $this->statusCode);
    }
}
