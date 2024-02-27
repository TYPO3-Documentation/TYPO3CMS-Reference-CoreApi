<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Controller\Ajax;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\JsonResponse;

final class ImportDataController
{
    public function importDataAction(ServerRequestInterface $request): ResponseInterface
    {
        $queryParameters = $request->getParsedBody();
        $id = (int)($queryParameters['id'] ?? 0);

        if ($id === 0) {
            return new JsonResponse(['success' => false]);
        }
        $param = ' -id=' . $id;

        // trigger data import (simplified as example)
        $output = shell_exec('.' . DIRECTORY_SEPARATOR . 'import.sh' . $param);

        return new JsonResponse(['success' => true, 'output' => $output]);
    }
}
