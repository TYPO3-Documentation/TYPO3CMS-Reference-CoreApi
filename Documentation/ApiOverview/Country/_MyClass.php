<?php

declare(strict_types=1);

namespace MyVendor\MyExtension;

use TYPO3\CMS\Core\Country\CountryProvider;

final class MyClass
{
    public function __construct(
        private readonly CountryProvider $countryProvider,
    ) {}
}
