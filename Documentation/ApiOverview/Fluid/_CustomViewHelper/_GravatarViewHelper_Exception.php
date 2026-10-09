<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\ViewHelpers;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\InvalidArgumentValueException;

final class GravatarViewHelper extends AbstractTagBasedViewHelper
{
  public function initializeArguments(): void
  {
    $this->registerArgument(
      'emailAddress',
      'string',
      'The email address to resolve the gravatar for',
      true,
    );
    $this->registerArgument(
      'size',
      'integer',
      'The size of the gravatar, ranging from 1 to 512',
      false,
      80,
    );
  }

  public function render(): string
  {
    $size = (int)$this->arguments['size'];
    if ($size < 1 || $size > 512) {
      throw new InvalidArgumentValueException(
        sprintf(
          'The size "%d" supplied to the gravatar ViewHelper is outside'
            . ' the range from 1 to 512.',
          $size,
        ),
        1791205354,
      );
    }
    $this->tag->addAttribute(
      'src',
      sprintf(
        'http://www.gravatar.com/avatar/%s?s=%s',
        md5($this->arguments['emailAddress']),
        urlencode((string)$size),
      ),
    );
    return $this->tag->render();
  }
}
