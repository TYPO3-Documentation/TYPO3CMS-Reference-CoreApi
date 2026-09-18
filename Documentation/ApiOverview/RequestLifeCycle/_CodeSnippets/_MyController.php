<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Controller;

use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

final class MyController extends ActionController
{
  // ...

  public function myAction(): ResponseInterface
  {
    // ...

    // Retrieve the language attribute via the request object
    $language = $this->request->getAttribute('language');

    // ...

    return $this->htmlResponse();
  }
}
