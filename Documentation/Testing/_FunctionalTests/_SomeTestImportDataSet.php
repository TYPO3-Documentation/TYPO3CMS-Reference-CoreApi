<?php

namespace MyVendor\MyExtension\Tests\Functional;

use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

/**
 * Test case
 */
class SomeTest extends FunctionalTestCase
{
    public function testSomething()
    {
        // Load a xml file relative to test case file
        $this->importCSVDataSet(__DIR__ . '/../Fixtures/pages.csv');
        // Load a xml file of some extension
        $this->importCSVDataSet('EXT:frontend/Tests/Functional/Fixtures/pages-title-tag.csv');
        // Load a xml file provided by the typo3/testing-framework package
        $this->importCSVDataSet('PACKAGE:typo3/testing-framework/Resources/Core/Functional/Fixtures/pages.csv');
    }
}
