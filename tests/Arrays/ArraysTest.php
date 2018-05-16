<?php

namespace Tests\Arrays;

use PhpSolution\StdLib\Arrays\Arrays;
use PHPUnit\Framework\TestCase;

/**
 * @see Arrays
 */
class ArraysTest extends TestCase
{
    /**
     * @see Arrays::indexByField()
     */
    public function testIndexByField(): void
    {
        $expected = array_combine([1, 3, 5, 7, 9], $this->getFixtures());
        $actual = Arrays::indexByField($this->getFixtures(), 'a');
        $this->assertEquals($expected, $actual);
    }

    /**
     * @see Arrays::paginate()
     */
    public function testPaginate(): void
    {
        $expected = array_combine([1, 3, 5, 7, 9], $this->getFixtures());
        $actual = Arrays::indexByField($this->getFixtures(), 'a');
        $this->assertEquals($expected, $actual);
    }

    /**
     * @return array
     */
    private function getFixtures(): array
    {
        return [
            ['a' => 1, 'b' => 2],
            ['a' => 3, 'b' => 6],
            ['a' => 5, 'b' => 4],
            ['a' => 7, 'b' => 8],
            ['a' => 9, 'b' => 10],
        ];
    }
}
