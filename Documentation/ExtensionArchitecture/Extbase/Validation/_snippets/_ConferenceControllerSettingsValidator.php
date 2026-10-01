<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Controller;

use MyVendor\MyExtension\Domain\Model\Conference;
use MyVendor\MyExtension\Validation\Validator\SeatCountValidator;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Validation\Validator\ConjunctionValidator;

class ConferenceController extends ActionController
{
  protected function initializeRegisterAction(): void
  {
    $seatCountValidator = GeneralUtility::makeInstance(SeatCountValidator::class);
    $seatCountValidator->setOptions([
      'minimum' => (int)($this->settings['registration']['minimumSeats'] ?? 1),
    ]);
    $seatCountValidator->setRequest($this->request);

    // Extbase has already attached the declared validators to the argument.
    // The configured validator is added to them.
    $argumentValidator = $this->arguments->getArgument('conference')->getValidator();
    if ($argumentValidator instanceof ConjunctionValidator) {
      $argumentValidator->addValidator($seatCountValidator);
    }
  }

  public function registerAction(Conference $conference): ResponseInterface
  {
    // Only reached when SeatCountValidator passes
    return $this->htmlResponse();
  }
}
