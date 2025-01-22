<?php

declare(strict_types=1);

namespace TYPO3\CMS\Core\Configuration;

use Symfony\Component\DependencyInjection\Attribute\AsAlias;

#[AsAlias('extension-configuration', public: true)]
class ExtensionConfiguration
{
    public function get(string $extension, string $path = ''): mixed
    {
        // implementation
    }
}
