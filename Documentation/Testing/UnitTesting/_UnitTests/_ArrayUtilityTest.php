<?php

namespace TYPO3\CMS\Core\Tests\Unit\Utility;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use TYPO3\CMS\Core\Utility\ArrayUtility;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

final class ArrayUtilityTest extends UnitTestCase
{
    #[DataProvider('filterByValueRecursive')]
    #[Test]
    public function filterByValueRecursiveCorrectlyFiltersArray(
        $needle,
        $haystack,
        $expectedResult,
    ): void {
        self::assertEquals(
            $expectedResult,
            ArrayUtility::filterByValueRecursive($needle, $haystack),
        );
    }
}
