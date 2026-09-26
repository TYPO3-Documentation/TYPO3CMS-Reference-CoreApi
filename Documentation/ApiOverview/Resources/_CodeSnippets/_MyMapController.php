<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Controller;

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\SystemResource\Publishing\SystemResourcePublisherInterface;
use TYPO3\CMS\Core\SystemResource\Publishing\UriGenerationOptions;
use TYPO3\CMS\Core\SystemResource\SystemResourceFactory;

final readonly class MyMapController
{
  public function __construct(
    private SystemResourceFactory $systemResourceFactory,
    private SystemResourcePublisherInterface $resourcePublisher,
  ) {}

  public function getAddressesUrl(ServerRequestInterface $request): string
  {
    $resource = $this->systemResourceFactory->createPublicResource(
      'PKG:my-vendor/my-extension:Resources/Public/XML/addresses.xml',
    );
    // The URL contains a cache buster, pass an absolute URL to the browser
    return (string)$this->resourcePublisher->generateUri(
      $resource,
      $request,
      new UriGenerationOptions(absoluteUri: true),
    );
  }
}
