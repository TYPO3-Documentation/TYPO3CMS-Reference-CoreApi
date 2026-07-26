<?php

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Backend\Template\ModuleTemplate;

final readonly class AdminModuleController
{
    private function debugAction(
        ServerRequestInterface $request,
        ModuleTemplate $view,
    ): ResponseInterface {
        $body = $request->getParsedBody();
        if (is_array($body)) {
            $cmd = $body['tx_examples_admin_examples']['cmd'] ?? 'cookies';
            switch ($cmd) {
                case 'cookies':
                    $this->debugCookies();
                    break;
                default:
                    // do something else
            }

            $view->assignMultiple(
                [
                    'cookies' => $request->getCookieParams(),
                    'lastcommand' => $cmd,
                ],
            );
        }
        return $view->renderResponse('AdminModule/Debug');
    }
}
