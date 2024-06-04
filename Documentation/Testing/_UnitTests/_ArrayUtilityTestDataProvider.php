<?php

namespace TYPO3\CMS\Core\Tests\Unit\Utility;

use TYPO3\CMS\Core\Utility\ArrayUtility;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class ArrayUtilityTest extends UnitTestCase
{
    /**
     * Data provider for removeByPathRemovesCorrectPath
     */
    public function removeByPathRemovesCorrectPathDataProvider()
    {
        return [
            'single value' => [
                [
                    'foo' => [
                        'toRemove' => 42,
                        'keep' => 23,
                    ],
                ],
                'foo/toRemove',
                [
                    'foo' => [
                        'keep' => 23,
                    ],
                ],
            ],
            'whole array' => [
                [
                    'foo' => [
                        'bar' => 42,
                    ],
                ],
                'foo',
                [],
            ],
            'sub array' => [
                [
                    'foo' => [
                        'keep' => 23,
                        'toRemove' => [
                            'foo' => 'bar',
                        ],
                    ],
                ],
                'foo/toRemove',
                [
                    'foo' => [
                        'keep' => 23,
                    ],
                ],
            ],
        ];
    }

    /**
     * @test
     * @dataProvider removeByPathRemovesCorrectPathDataProvider
     * @param array $array
     * @param string $path
     * @param array $expectedResult
     */
    public function removeByPathRemovesCorrectPath(array $array, $path, $expectedResult)
    {
        self::assertEquals(
            $expectedResult,
            ArrayUtility::removeByPath($array, $path),
        );
    }
}
