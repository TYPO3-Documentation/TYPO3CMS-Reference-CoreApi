<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Service;

use Symfony\Component\DependencyInjection\Attribute\Autowire;

class MyServiceGettingFeatureToggleResultInjected
{
    public function __construct(
        #[Autowire(expression: 'service("features").isFeatureEnabled("myExtension.foo")')]
        private readonly bool $fooEnabled,
    ) {}
}
