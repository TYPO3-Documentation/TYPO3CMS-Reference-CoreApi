<?php

declare(strict_types=1);

use a9f\Fractor\Configuration\FractorConfiguration;
use a9f\FractorXliff\CodeQuality\EnsureXliffHasSourceLanguageFractor;
use a9f\FractorXliff\CodeQuality\EnsureXliffHasTargetLanguageFractor;
use a9f\FractorXliff\Configuration\XliffProcessorOption;
use a9f\FractorXliff\Transform\ConvertXliff1To2Fractor;

return FractorConfiguration::configure()
    ->withPaths([
        __DIR__ . '/packages/',
        __DIR__ . '/Resources/Private/Language/', // for extension authors
    ])
    ->withRules([
        ConvertXliff1To2Fractor::class,
        EnsureXliffHasSourceLanguageFractor::class,
        EnsureXliffHasTargetLanguageFractor::class,
    ])
    ->withOptions([
        XliffProcessorOption::INDENT_SIZE => 2,
    ])
;
