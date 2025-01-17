<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Service;

use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Core\Cache\Frontend\FrontendInterface;

class MyServiceUsingCacheManager
{
    private FrontendInterface $runtimeCache;

    public function __construct(
        CacheManager $cacheManager,
    ) {
        $this->runtimeCache = $cacheManager->getCache('runtime');
    }

    public function calculateSomethingExpensive()
    {
        // do something using runtime cache
    }
}
