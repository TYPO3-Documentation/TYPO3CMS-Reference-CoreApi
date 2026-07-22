<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Enum;

enum Status: string
{
    case DRAFT = 'draft';
    case IN_REVIEW = 'in-review';
    case PUBLISHED = 'published';

    public const LLL_PREFIX = 'LLL:EXT:my_extension/Resources/Private/Language/locallang.xlf:status-';

    public function getLabel(): string
    {
        return self::LLL_PREFIX . $this->value;
    }
}
