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
            ->compare();

        $this->assertEquals($expectedResult, $result);
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

        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @return array
     */
    public function compareArraysWithSubArraysDataProvider(): array
    {
        return [
            'Unequal array' => [
                'expected' => ['subArray' => ['a']],
                'actual' => ['subArray' => ['b']],
                'expectedResult' => false,
            ],
            'Unequal array because of wrong data type' => [
                'expected' => ['subArray' => 'a'],
                'actual' => ['subArray' => ['b']],
                'expectedResult' => false,
            ],
            'Equal array' => [
                'expected' => ['subArray' => ['a']],
                'actual' => ['subArray' => ['a']],
                'expectedResult' => true,
            ],
            'Equal empty array' => [
                'expected' => [],
                'actual' => [],
                'expectedResult' => true,
            ],
            'Equal shuffled array' => [
                'expected' => ['subArray' => ['a', 'b', 'c']],
                'actual' => ['subArray' => ['c', 'b', 'a']],
                'expectedResult' => true,
            ],
        ];
    }

    /**
     * @see ArrayComparator
     *
     * @dataProvider compareArraysWithSubAssocDataProvider
     *
     * @param array $expected
     * @param array $actual
     * @param bool  $expectedResult
     */
    public function testCompareArraysWithSubAssoc(array $expected, array $actual, bool $expectedResult): void
    {
        $result = (new ArrayComparator($expected, $actual))
            ->subAssoc('assoc')
                ->skip('skip')
                ->subArray('array')
                ->subAssoc('subAssoc')
                    ->compare()
                ->compare()
            ->compare();

        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @return array
     */
    public function compareArraysWithSubAssocDataProvider(): array
    {
        return [
            'Equal empty array' => [
                'expected' => [],
                'actual' => [],
                'expectedResult' => true,
            ],
            'Equal complex array' => [
                'expected' => [
                    'a' => 'b',
                    'assoc' => [
                        1 => 2,
                        'skip' => 'c',
                        'array' => ['a', 'b', 'c'],
                        'subAssoc' => [
                            4 => 'a'
                        ]
                    ]
                ],
                'actual' => [
                    'a' => 'b',
                    'assoc' => [
                        1 => 2,
                        'skip' => 'd',
                        'array' => ['b', 'c', 'a'],
                        'subAssoc' => [
                            4 => 'a'
                        ]
                    ]
                ],
                'expectedResult' => true,
            ],
            'Unequal complex array' => [
                'expected' => [
                    'a' => 'b',
                    'assoc' => [
                        1 => 2,
                        'skip' => 'c',
                        'array' => ['a', 'b', 'c'],
                        'subAssoc' => [
                            4 => 'a'
                        ]
                    ]
                ],
                'actual' => [
                    'a' => 'b',
                    'assoc' => [
                        1 => 2,
                        'skip' => 'd',
                        'array' => ['b', 'c'],
                        'subAssoc' => [
                            4 => 'a'
                        ]
                    ]
                ],
                'expectedResult' => false,
            ]
        ];
    }
}
