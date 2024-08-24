<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\Controller\ErrorController;

class NotAvailableMiddleware implements MiddlewareInterface {
    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface
    {
        if ($request->getRequestTarget() === 'foo/bar') {
            return GeneralUtility::makeInstance(ErrorController::class)
                ->unavailableAction(
                    $request,
                    'This page is temporarily unavailable.'
                );
        }

        return $handler->handle($request);
    }
}
