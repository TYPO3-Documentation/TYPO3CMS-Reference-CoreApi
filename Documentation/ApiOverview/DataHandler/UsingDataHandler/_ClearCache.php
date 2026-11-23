<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\DataHandling;

use TYPO3\CMS\Core\Authentication\BackendUserAuthentication;
use TYPO3\CMS\Core\Cache\Flush\CacheFlushDemand;
use TYPO3\CMS\Core\Cache\Flush\CacheFlusher;
use TYPO3\CMS\Core\Cache\Flush\CacheFlushingContext;

final readonly class MyClass
{
  public function __construct(
    private CacheFlusher $cacheFlusher,
  ) {}

  public function clearCache(BackendUserAuthentication $backendUser): void
  {
    $this->cacheFlusher->flush(
      CacheFlushDemand::forCommand('all'),
      // Flush only what the backend user may flush
      CacheFlushingContext::fromBackendUser($backendUser),
    );
  }
}
