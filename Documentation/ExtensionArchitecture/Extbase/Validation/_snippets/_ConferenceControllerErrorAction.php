<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Controller;

use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class ConferenceController extends ActionController
{
  #[\Override]
  protected function errorAction(): ResponseInterface
  {
    $errors = $this->arguments->validate();
    // Choose the status code appropriate for your API,
    // 422 and 400 are both common choices
    return $this->jsonResponse(json_encode([
      'errors' => $this->flattenErrors($errors),
    ]))->withStatus(422);
  }
}
