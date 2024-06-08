<?php

namespace MyVendor\MyExtension\Tests\Functional;

use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

/**
 * Test case
 */
class SomeTest extends FunctionalTestCase
{
    protected array $coreExtensionsToLoad = [
        'workspaces',
    ];

    public function testSomethingWithWorkspaces()
    {
        //...
    }
}
