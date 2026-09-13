<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\UserFunction;

use Psr\Http\Message\ServerRequestInterface;

final class MyUserFunction
{
  public function doSomething(
    string $content,
    array $conf,
    ServerRequestInterface $request,
  ): string {
    // ...

    // Retrieve the language attribute via the request object
    $language = $request->getAttribute('language');

    // ...
  }
}
