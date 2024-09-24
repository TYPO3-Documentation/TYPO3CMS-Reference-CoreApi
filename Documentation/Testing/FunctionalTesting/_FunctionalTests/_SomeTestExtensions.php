<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Tests\Functional;

use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

class SomeTest extends FunctionalTestCase
{
    protected array $testExtensionsToLoad = [
        'typo3conf/ext/some_extension/Tests/Functional/Fixtures/Extensions/test_extension',
        'typo3conf/ext/base_extension',
    ];

    /**
     * @test
     */
    public function somethingWithExtensions(): void
    {
        //...
    }
}
