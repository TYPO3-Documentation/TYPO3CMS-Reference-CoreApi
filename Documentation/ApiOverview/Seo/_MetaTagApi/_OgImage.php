<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Controller;

use TYPO3\CMS\Core\MetaTag\MetaTagManagerRegistry;

final class MyController
{
    public function __construct(
        private readonly MetaTagManagerRegistry $metaTagManagerRegistry,
    ) {}

    public function addOgImage(): void
    {
        $metaTagManager = $this->metaTagManagerRegistry->getManagerForProperty('og:image');
        $metaTagManager->addProperty(
            'og:image',
            '/path/to/image.jpg',
            [
                'width' => 400,
                'height' => 400,
            ],
        );
    }
}
