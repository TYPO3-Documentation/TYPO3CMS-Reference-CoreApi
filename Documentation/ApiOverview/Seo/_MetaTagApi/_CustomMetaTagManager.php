<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\MetaTag;

use TYPO3\CMS\Core\Attribute\AsMetaTagManager;
use TYPO3\CMS\Core\MetaTag\AbstractMetaTagManager;

#[AsMetaTagManager(identifier: 'custom')]
final class CustomMetaTagManager extends AbstractMetaTagManager
{
    protected $handledProperties = [
        'my-custom-tag' => [],
    ];
}
