<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Service;

use Symfony\Component\DependencyInjection\Attribute\Autowire;
use TYPO3\CMS\Core\Cache\Frontend\FrontendInterface;

class MyServiceGettingRuntimeCacheInjected
{
    public function __construct(
        #[Autowire(service: 'cache.runtime')]
        private readonly FrontendInterface $runtimeCache,
    ) {}

    public function calculateSomethingExpensive()
    {
        // do something using runtime cache
    }
}
