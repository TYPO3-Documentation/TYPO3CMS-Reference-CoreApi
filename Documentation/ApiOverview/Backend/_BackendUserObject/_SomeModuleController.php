<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Controller;

use Psr\Http\Message\ServerRequestInterface;

final class SomeModuleController
{
  public function saveModuleData(ServerRequestInterface $request): void
  {
    $compareFlags = $request->getParsedBody()['compareFlags']
      ?? $request->getQueryParams()['compareFlags']
      ?? null;
    $GLOBALS['BE_USER']->pushModuleData(
      'tools_beuser/index.php/compare',
      $compareFlags,
    );
  }
}
