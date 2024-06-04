<?php

namespace TYPO3\CMS\Core\Tests\Unit\Utility;

use TYPO3\CMS\Core\Utility\ArrayUtility;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class ArrayUtilityTest extends UnitTestCase
{
    private ArrayUtility $subject;

    //...

    /**
     * @test
     * @dataProvider filterByValueRecursive
     */
    public function filterByValueRecursiveCorrectlyFiltersArray($needle, $haystack, $expectedResult): void
    {
        // Unit test code
    }
}
