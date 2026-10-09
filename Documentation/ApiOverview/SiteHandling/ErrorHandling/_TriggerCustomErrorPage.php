<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Controller;

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\PropagateResponseException;
use TYPO3\CMS\Frontend\Controller\ErrorController;

final readonly class DownloadController
{
  public function __construct(
    private ErrorController $errorController,
  ) {}

  public function downloadAction(ServerRequestInterface $request): never
  {
    $response = $this->errorController->customErrorAction(
      $request,
      429,
      'Too many requests',
      'You have requested too many downloads.',
      'Rate limit of 10 downloads per hour reached',
    );
    throw new PropagateResponseException($response, 1791205354);
  }
}
