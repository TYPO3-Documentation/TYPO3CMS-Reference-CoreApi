<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider;
use TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider;
use TYPO3\CMS\Core\Imaging\IconProvider\SvgSpriteIconProvider;

return [
    // Icon identifier
    'tx-myextension-svgicon' => [
        // Icon provider class
        'provider' => SvgIconProvider::class,
        // The source SVG for the SvgIconProvider
        'source' => 'EXT:my_extension/Resources/Public/Icons/mysvg.svg',
    ],
    'tx-myextension-bitmapicon' => [
        'provider' => BitmapIconProvider::class,
        // The source bitmap file
        'source' => 'EXT:my_extension/Resources/Public/Icons/mybitmap.png',
        // All icon providers provide the possibility to register an icon that spins
        'spinning' => true,
    ],
    'tx-myextension-anothersvgicon' => [
        'provider' => SvgIconProvider::class,
        'source' => 'EXT:my_extension/Resources/Public/Icons/anothersvg.svg',
        // Since TYPO3 v12.0 an extension that provides icons for broader
        // use can mark such icons as deprecated with logging to the TYPO3
        // deprecation log. All keys (since, until, replacement) are optional.
        'deprecated' => [
            'since' => 'my extension v2',
            'until' => 'my extension v3',
            'replacement' => 'alternative-icon',
        ],
    ],
    'tx-myextension-spriteicon' => [
        // Icon provider for SVG sprites
        'provider' => SvgSpriteIconProvider::class,
        // The SVG sprite with fragment identifier (<symbol id="…">)
        'sprite' => 'EXT:my_extension/Resources/Public/Icons/sprite.svg#tx-myextension',
    ],
];
