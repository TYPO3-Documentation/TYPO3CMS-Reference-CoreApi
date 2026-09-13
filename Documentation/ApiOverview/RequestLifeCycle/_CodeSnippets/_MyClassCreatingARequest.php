<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Service;

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Core\SystemEnvironmentBuilder;
use TYPO3\CMS\Core\Http\ServerRequest;
use TYPO3\CMS\Core\Site\SiteFinder;

final readonly class MyClass
{
  public function __construct(
    private SiteFinder $siteFinder,
  ) {}

  public function createRequest(): ServerRequestInterface
  {
    $site = $this->siteFinder->getSiteByPageId(1);
    return (new ServerRequest())
      ->withAttribute(
        'applicationType',
        SystemEnvironmentBuilder::REQUESTTYPE_FE,
      )
      ->withAttribute('site', $site);
  }
}
