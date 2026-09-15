<?php

declare(strict_types=1);

namespace Vendor\SomeExtension\Error;

use TYPO3\CMS\Core\Error\DebugExceptionHandler;

class PostExceptionsOnTwitter extends DebugExceptionHandler
{
  public function echoExceptionWeb(\Exception $exception)
  {
    $this->postExceptionsOnTwitter($exception);
  }

  public function postExceptionsOnTwitter($exception)
  {
    // do it ;-)
  }
}
