<?php

namespace MyVendor\MyExtension\Tests\Functional;

use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

/**
 * Test case
 */
class SomeTest extends FunctionalTestCase
{
    public function testSomethingWithWorkspaces()
    {
        $this->setUpFrontendRootPage(
            1,
            ['EXT:fluid_test/Configuration/TypoScript/Basic.typoscript'],
        );
    }
}
