<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Cache\Flush\CacheFlushDemand;
use TYPO3\CMS\Core\Cache\Flush\CacheFlushingContext;

$result = $this->cacheFlusher->flush(
  CacheFlushDemand::forCommand('pages'),
  CacheFlushingContext::fromBackendUser($GLOBALS['BE_USER']),
);
if ($result->skippedGroups !== []) {
  // The backend user may not flush the "pages" group
}
