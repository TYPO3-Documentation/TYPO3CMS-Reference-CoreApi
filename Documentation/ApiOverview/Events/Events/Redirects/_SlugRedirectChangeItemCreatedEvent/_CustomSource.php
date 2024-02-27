<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Redirects;

use TYPO3\CMS\Redirects\RedirectUpdate\RedirectSourceInterface;

final class CustomSource implements RedirectSourceInterface
{
    public function getHost(): string
    {
        return '*';
    }

    public function getPath(): string
    {
        return '/some-path';
    }

    public function getTargetLinkParameters(): array
    {
        return [];
    }
}
