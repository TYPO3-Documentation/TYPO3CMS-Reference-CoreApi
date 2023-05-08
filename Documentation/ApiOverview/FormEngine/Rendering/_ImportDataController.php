<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Controller\Ajax;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ImportDataController
{
    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function importDataAction(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $queryParameters = $request->getParsedBody();
        $id = (int)$queryParameters['id'];

        if ($id === 0) {
            $response->getBody()->write(json_encode(['success' => false]));
            return $response;
        }
        $param = ' -id=' . $id;

        // trigger data import (simplified as example)
        $output = shell_exec('.' . DIRECTORY_SEPARATOR . 'import.sh' . $param);

        $response->getBody()->write(json_encode(['success' => true, 'output' => $output]));
        return $response;
    }
}
