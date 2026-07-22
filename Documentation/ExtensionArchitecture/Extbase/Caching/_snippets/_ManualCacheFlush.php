<?php

namespace MyVendor\MyExtension\Service;

use TYPO3\CMS\Extbase\Service\CacheService;

class ConferenceImportService
{
    public function __construct(
        protected readonly CacheService $cacheService,
    ) {}

    public function flushAfterImport(int $pageId): void
    {
        // Flush the page cache of specific pages right away:
        $this->cacheService->clearPageCache([$pageId]);

        // Or register a record so the pages showing it are flushed at the end of
        // the request — this is what automatic cache clearing uses internally:
        $this->cacheService->clearCacheForRecord('tx_myextension_domain_model_conference', 42);
    }
}
