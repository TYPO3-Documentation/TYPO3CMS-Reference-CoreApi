<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Controller;

use TYPO3\CMS\Core\MetaTag\MetaTagManagerRegistry;

final class MyController
{
    public function __construct(
        private readonly MetaTagManagerRegistry $metaTagManagerRegistry,
    ) {}

    public function removeAllOgProperties(): void
    {
        $metaTagManager = $this->metaTagManagerRegistry->getManagerForProperty('og:title');
        $metaTagManager->removeAllProperties();
    }
}
