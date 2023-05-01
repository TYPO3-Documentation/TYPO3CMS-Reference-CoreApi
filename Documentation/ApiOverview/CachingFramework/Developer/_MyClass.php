<?php

namespace Vendor\MyExtension;

use TYPO3\CMS\Core\Cache\Frontend\FrontendInterface;

final class MyClass
{
    public function __construct(
        private readonly FrontendInterface $cache
    ) {
    }

    //...

    private function getCachedValue(string $cacheIdentifier, array $data, array $tags, int|null $lifetime)
    {
        // If value is false, it has not been cached
        $value = $this->cache->get($cacheIdentifier);
        if ($value === false) {
            // Store the data in cache
            $this->cache->set($cacheIdentifier, $data, $tags, $lifetime);
        }

        return $value;
    }
}
