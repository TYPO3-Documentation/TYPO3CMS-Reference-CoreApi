<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Service;

use Symfony\Component\DependencyInjection\Attribute\Autowire;

class MyServiceGettingExtensionConfigurationValueInjected
{
    public function __construct(
        #[Autowire(expression: 'service("extension-configuration").get("my_extension", "something.isEnabled")')]
        private readonly bool $somethingIsEnabled,
    ) {}
}
