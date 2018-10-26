<?php
declare(strict_types=1);

namespace Tests\Arrays;

use PhpSolution\StdLib\Arrays\ArrayComparator;
use PHPUnit\Framework\TestCase;

/**
 * @see ArrayComparator
 */
final class ArrayComparatorTest extends TestCase
{
    /**
     * @see ArrayComparator
     *
     * @dataProvider compareSimpleArraysDataProvider
     *
     * @param array $expected
     * @param array $actual
     * @param bool  $expectedResult
     */
    public function testCompareSimpleArrays(array $expected, array $actual, bool $expectedResult): void
    {
        $result = (new ArrayComparator($expected, $actual))
            ->skip('1')
            ->skipNulls()
            ->compare();

        self::assertEquals($expectedResult, $result);
    }

    /**
     * @return array
     */
    public function compareSimpleArraysDataProvider(): array
    {
        return [
            'Unequal arrays' => [
                'expected' => ['a' => 'b'],
                'actual' => ['a' => 'c'],
                'expectedResult' => false,
            ],
            'Equal arrays' => [
                'expected' => ['a' => 'b'],
                'actual' => ['a' => 'b'],
                'expectedResult' => true,
            ],
            'Equal arrays with skip' => [
                'expected' => ['a' => 'b', 1 => 'c'],
                'actual' => ['a' => 'b'],
                'expectedResult' => true,
            ],
            'Equal arrays with null' => [
                'expected' => ['a' => 'b', 1 => 'c', 'd' => null],
                'actual' => ['a' => 'b'],
                'expectedResult' => true,
            ],
        ];
    }

    /**
     * @see ArrayComparator
     *
     * @dataProvider compareArraysWithSubArraysDataProvider
     *
     * @param array $expected
     * @param array $actual
     * @param bool  $expectedResult
     */
    public function testCompareArraysWithSubArrays(array $expected, array $actual, bool $expectedResult): void
    {
        $result = (new ArrayComparator($expected, $actual))
            ->subArray('subArray')
            ->compare();

        self::assertEquals($expectedResult, $result);
    }

    /**
     * @return array
     */
    public function compareArraysWithSubArraysDataProvider(): array
    {
        return [
            'Unequal arrays' => [
                'expected' => ['subArray' => ['a']],
                'actual' => ['subArray' => ['b']],
                'expectedResult' => false,
            ],
            'Unequal arrays because of wrong data type' => [
                'expected' => ['subArray' => 'a'],
                'actual' => ['subArray' => ['b']],
                'expectedResult' => false,
            ],
            'Equal arrays' => [
                'expected' => ['subArray' => ['a']],
                'actual' => ['subArray' => ['a']],
                'expectedResult' => true,
            ],
            'Equal empty arrays' => [
                'expected' => ['subArray' => null],
                'actual' => ['subArray' => null],
                'expectedResult' => true,
            ],
            'Equal null arrays' => [
                'expected' => [],
                'actual' => [],
                'expectedResult' => true,
            ],
            'Equal shuffled arrays' => [
                'expected' => ['subArray' => ['a', 'b', 'c']],
                'actual' => ['subArray' => ['c', 'b', 'a']],
                'expectedResult' => true,
            ],
        ];
    }

    /**
     * @see ArrayComparator
     *
     * @dataProvider compareArraysWithSubObjectDataProvider
     *
     * @param array $expected
     * @param array $actual
     * @param bool  $expectedResult
     */
    public function testCompareArraysWithSubObject(array $expected, array $actual, bool $expectedResult): void
    {
        $result = (new ArrayComparator($expected, $actual))
            ->subObject('object')
                ->skip('skip')
                ->subArray('array')
                ->subObject('subObject')
                    ->compare()
                ->compare()
            ->compare();

        self::assertEquals($expectedResult, $result);
    }

    /**
     * @return array
     */
    public function compareArraysWithSubObjectDataProvider(): array
    {
        return [
            'Equal empty arrays' => [
                'expected' => [],
                'actual' => [],
                'expectedResult' => true,
            ],
            'Equal complex arrays' => [
                'expected' => [
                    'a' => 'b',
                    'object' => [
                        1 => 2,
                        'skip' => 'c',
                        'array' => ['a', 'b', 'c'],
                        'subObject' => [
                            4 => 'a'
                        ]
                    ]
                ],
                'actual' => [
                    'a' => 'b',
                    'object' => [
                        1 => 2,
                        'skip' => 'd',
                        'array' => ['b', 'c', 'a'],
                        'subObject' => [
                            4 => 'a'
                        ]
                    ]
                ],
                'expectedResult' => true,
            ],
            'Unequal complex arrays' => [
                'expected' => [
                    'a' => 'b',
                    'object' => [
                        1 => 2,
                        'skip' => 'c',
                        'array' => ['a', 'b', 'c'],
                        'subObject' => [
                            4 => 'a'
                        ]
                    ]
                ],
                'actual' => [
                    'a' => 'b',
                    'object' => [
                        1 => 2,
                        'skip' => 'd',
                        'array' => ['b', 'c'],
                        'subObject' => [
                            4 => 'a'
                        ]
                    ]
                ],
                'expectedResult' => false,
            ]
        ];
    }

    /**
     * @see ArrayComparator
     *
     * @dataProvider compareArraysWithSubArrayOfObjectDataProvider
     *
     * @param array $expected
     * @param array $actual
     * @param bool  $expectedResult
     */
    public function testCompareArraysWithSubArrayOfObject(array $expected, array $actual, bool $expectedResult): void
    {
        $result = (new ArrayComparator($expected, $actual))
            ->subArrayOfObject('array')
            ->compare();

        self::assertEquals($expectedResult, $result);
    }

    /**
     * @return array
     */
    public function compareArraysWithSubArrayOfObjectDataProvider(): array
    {
        return [
            'Equal arrays' => [
                'expected' => [
                    'array' => [
                        ['a' => 'a', 'b' => 'b'],
                        ['a' => 'b', 'b' => 'a'],
                    ]
                ],
                'actual' => [
                    'array' => [
                        ['a' => 'a', 'b' => 'b'],
                        ['a' => 'b', 'b' => 'a'],
                    ]
                ],
                'expectedResult' => true,
            ],
            'Unequal arrays' => [
                'expected' => [
                    'array' => [
                        ['a' => 'a', 'b' => 'b'],
                        ['a' => 'b', 'b' => 'a'],
                    ]
                ],
                'actual' => [
                    'array' => [
                        ['a' => 'a', 'b' => 'c'],
                        ['a' => 'b', 'b' => 'a'],
                    ]
                ],
                'expectedResult' => false,
            ],
        ];
    }
}
