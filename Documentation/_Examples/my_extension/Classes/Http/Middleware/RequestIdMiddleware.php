<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Http\Middleware;

use Psr\Http\Message\RequestInterface;

/**
 * Guzzle middleware that gives each outgoing request an ID, so that the
 * logs of the receiving service can be matched with the logs of TYPO3
 */
final class RequestIdMiddleware
{
  public function __invoke(callable $handler): callable
  {
    return static fn(RequestInterface $request, array $options) => $handler(
      $request->withHeader('X-Request-Id', bin2hex(random_bytes(8))),
      $options,
    );
  }
}
