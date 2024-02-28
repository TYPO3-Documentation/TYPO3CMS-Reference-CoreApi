<?php

declare(strict_types=1);

use TYPO3\CMS\Core\DataHandling\SoftReference\SoftReferenceParserFactory;

final class MyController
{
    public function __construct(
        private readonly SoftReferenceParserFactory $softReferenceParserFactory,
    ) {}

    public function doSomething(): void
    {
        // Get the soft reference parser with the key "my_softref_key"
        $mySoftRefParser = $this->softReferenceParserFactory->getSoftReferenceParser(
            'my_softref_key',
        );

        // ... do something with $mySoftRefParser
    }
}
