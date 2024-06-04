<?php

namespace MyVendor\MyExtension\Tests\Functional;

use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

/**
 * Test case
 */
class SomeTest extends FunctionalTestCase
{
    protected array $testExtensionsToLoad = [
        'typo3conf/ext/some_extension/Tests/Functional/Fixtures/Extensions/test_extension',
        'typo3conf/ext/base_extension',
    ];

    public function testSomethingWithExtensions()
    {
        //...
    }
}
