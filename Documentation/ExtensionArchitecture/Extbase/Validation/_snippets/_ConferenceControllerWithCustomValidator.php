<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Controller;

use MyVendor\MyExtension\Domain\Model\Conference;
use MyVendor\MyExtension\Validation\Validator\SeatCountValidator;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Extbase\Attribute\Validate;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class ConferenceController extends ActionController
{
  public function registerAction(
    #[Validate(SeatCountValidator::class, options: ['minimum' => 1])]
    Conference $conference,
  ): ResponseInterface {
    // Only reached when SeatCountValidator passes
  }
}
