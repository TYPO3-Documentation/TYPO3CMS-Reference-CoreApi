<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Controller;

use TYPO3\CMS\Extbase\Attribute\Validate;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class ConferenceController extends ActionController
{
  public function createAction(
    #[Validate('NotEmpty')]
    #[Validate('StringLength', options: ['maximum' => 255])]
    string $title,
  ): ResponseInterface {
    // $title is guaranteed non-empty and at most 255 characters
  }
}
