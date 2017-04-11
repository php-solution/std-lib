<?php
namespace Tests\Collection;

use PhpSolution\StdLib\Collection\GenericCollection;
use PHPUnit\Framework\TestCase;

/**
 * @see \PhpSolution\StdLib\Collection\GenericCollection
 */
class GenericCollectionTest extends TestCase
{
    /**
     * @see \PhpSolution\StdLib\Collection\GenericCollection
     */
    public function testPositive()
    {
        $collection = new GenericCollection(\DateTime::class);
        $date = new \DateTime();
        $collection[] = $date;
        $this->assertEquals(1, $collection->count());
        $this->assertEquals($date, $collection[0]);
    }

    /**
     * @see \PhpSolution\StdLib\Collection\GenericCollection
     */
    public function testNegative()
    {
        $this->expectException(\UnexpectedValueException::class);
        $collection = new GenericCollection(\DateTime::class);
        $collection[] = 1;
    }
}