<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Service;

use TYPO3\CMS\Core\Cache\Flush\CacheFlushDemand;
use TYPO3\CMS\Core\Cache\Flush\CacheFlusher;

final readonly class MyImportService
{
  public function __construct(
    private CacheFlusher $cacheFlusher,
  ) {}

  public function import(int $newsUid): void
  {
    // ... write the record ...

    $result = $this->cacheFlusher->flush(
      CacheFlushDemand::forRecord('tx_myextension_news', $newsUid),
    );
    foreach ($result->errors as $error) {
      // ... report the error ...
    }
  }
}
