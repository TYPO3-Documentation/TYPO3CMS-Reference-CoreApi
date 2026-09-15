<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Validation\Validator;

use TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator;

class ConferenceSpeakerValidator extends AbstractValidator
{
  protected function isValid(mixed $value): void
  {
    $secondsUntilStart = $value->getStartDate()->getTimestamp() - time();
    $weeksUntilStart = (int)($secondsUntilStart / 604800);
    if ($weeksUntilStart < 4 && $value->getSpeaker() === null) {
      $this->addErrorForProperty(
        'speaker',
        $this->translateErrorMessage(
          'my_extension.messages:validator.conference.speakerRequired',
        ),
        1716300100,
      );
    }
  }
}
