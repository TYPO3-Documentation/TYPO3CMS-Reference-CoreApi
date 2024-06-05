<?php

namespace TYPO3\CMS\Core\Tests\Unit\Utility;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use TYPO3\CMS\Core\Utility\ArrayUtility;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class ArrayUtilityTest extends UnitTestCase
{
    /**
     * Data provider for filterByValueRecursiveCorrectlyFiltersArray
     *
     * Every array splits into:
     * - String value to search for
     * - Input array
     * - Expected result array
     */
    public static function filterByValueRecursive(): array
    {
        return [
            'empty search array' => [
                'banana',
                [],
                [],
            ],
            'empty string as needle' => [
                '',
                [
                    '',
                    'apple',
                ],
                [
                    '',
                ],
            ],
            'flat array searching for string' => [
                'banana',
                [
                    'apple',
                    'banana',
                ],
                [
                    1 => 'banana',
                ],
            ],
            // ...
        ];
    }

    /**
     * @param array $needle
     * @param array $haystack
     * @param array $expectedResult
     */
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
