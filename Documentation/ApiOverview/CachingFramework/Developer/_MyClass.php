<?php

namespace MyVendor\MyExtension;

use TYPO3\CMS\Core\Cache\Frontend\FrontendInterface;

final class MyClass
{
    public function __construct(
        private readonly FrontendInterface $cache,
    ) {}

    //...

    private function getCachedValue(string $cacheIdentifier, array $tags, int|null $lifetime): array
    {
        // If value is false, it has not been cached
        $value = $this->cache->get($cacheIdentifier);
        if ($value === false) {
            // Store the data in cache
            $value = $this->calculateData();
            $this->cache->set($cacheIdentifier, $value, $tags, $lifetime);
        }

        return $value;
    }

    private function calculateData(): array
    {
        $data = [];
        // todo: implement
        return $data;
    }
}
