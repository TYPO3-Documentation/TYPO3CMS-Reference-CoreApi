<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Controller;

use MyVendor\MyExtension\Domain\Model\Conference;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Extbase\Attribute\IgnoreValidation;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class ConferenceController extends ActionController
{
  public function previewAction(
    #[IgnoreValidation]
    Conference $conference,
  ): ResponseInterface {
    // validation skipped for $conference
  }
}
