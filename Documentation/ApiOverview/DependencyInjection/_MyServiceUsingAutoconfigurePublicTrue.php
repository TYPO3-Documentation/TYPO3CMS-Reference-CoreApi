<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Service;

use Symfony\Component\DependencyInjection\Attribute\Autoconfigure;

/**
 * This service is instantiated using GeneralUtility::makeInstance()
 * in some cases, which requires 'public' being set to 'true'.
 */
#[Autoconfigure(public: true)]
readonly class MyServiceUsingAutoconfigurePublicTrue
{
    public function __construct(
        private SomeDependency $someDependency,
    ) {}
}
