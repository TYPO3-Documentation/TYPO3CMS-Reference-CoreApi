<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Service;

use Symfony\Component\DependencyInjection\Attribute\Autoconfigure;

/**
 * This service is stateful and configures the service container to
 * inject new instances to consuming services when they are instantiated.
 */
#[Autoconfigure(shared: false)]
class MyServiceUsingAutoconfigureSharedFalse
{
    private string $foo = 'foo';

    public function __construct(
        private readonly SomeDependency $someDependency,
    ) {}

    public function setFoo(): void
    {
        $this->foo = 'bar';
    }
}
