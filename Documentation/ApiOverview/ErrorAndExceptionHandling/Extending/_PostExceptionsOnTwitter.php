<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Error;

use TYPO3\CMS\Core\Error\DebugExceptionHandler;

class PostExceptionsOnTwitter extends DebugExceptionHandler
{
  public function echoExceptionWeb(\Throwable $exception)
  {
    $this->postExceptionsOnTwitter($exception);
  }

  public function postExceptionsOnTwitter($exception)
  {
    // do it ;-)
  }
}
