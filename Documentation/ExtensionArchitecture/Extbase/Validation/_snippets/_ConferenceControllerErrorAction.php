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
    $errors = [];
    // getFlattenedErrors() lists the errors by property path,
    // for example "conference.title"
    foreach ($this->arguments->validate()->getFlattenedErrors() as $propertyPath => $propertyErrors) {
      foreach ($propertyErrors as $error) {
        $errors[$propertyPath][] = $error->render();
      }
    }
    // Choose the status code appropriate for your API,
    // 422 and 400 are both common choices
    return $this->jsonResponse(json_encode([
      'errors' => $errors,
    ]))->withStatus(422);
  }
}
