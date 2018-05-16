<?php

namespace Tests\Period\Computation;

use PhpSolution\StdLib\Consequence\Change;
use PhpSolution\StdLib\Consequence\Creation;
use PhpSolution\StdLib\Consequence\Destruction;
use PhpSolution\StdLib\Period\Computation;

/**
 * @see Computation::subtraction()
 */
class SubtractionTest extends AbstractComputationTest
{
    /**
     * @see Computation::subtraction()
     */
    public function testDestruction()
    {
        $april = $this->getAprilPeriod();

        $result = Computation::subtraction($april, $april);
        $this->assertEquals(1, $result->count());
        $this->assertInstanceOf(Destruction::class, $result[0]);
    }

    /**
     * @see Computation::subtraction()
     */
    public function testLeftFirstDay()
    {
        $april = $this->getAprilPeriod();
        $subtrahend = $this->getAprilPeriod();
        $subtrahend->getFrom()->modify('+1 day');

        $result = Computation::subtraction($april, $subtrahend);
        $this->assertEquals(1, $result->count());
        $this->assertInstanceOf(Change::class, $result[0]);
        $this->assertEquals(new \DateTime('2000-04-01 00:00:00'), $april->getFrom());
        $this->assertEquals(new \DateTime('2000-04-01 23:59:59'), $april->getTo());
    }

    /**
     * @see Computation::subtraction()
     */
    public function testLeftLastDay()
    {
        $april = $this->getAprilPeriod();
        $subtrahend = $this->getAprilPeriod();
        $subtrahend->getTo()->modify('-1 day');

        $result = Computation::subtraction($april, $subtrahend);
        $this->assertEquals(1, $result->count());
        $this->assertInstanceOf(Change::class, $result[0]);
        $this->assertEquals(new \DateTime('2000-04-30 00:00:00'), $april->getFrom());
        $this->assertEquals(new \DateTime('2000-04-30 23:59:59'), $april->getTo());
    }

    /**
     * @see Computation::subtraction()
     */
    public function testLeftLastAndFirstDay()
    {
        $april = $this->getAprilPeriod();
        $subtrahend = $this->getAprilPeriod();
        $subtrahend->getFrom()->modify('+1 day');
        $subtrahend->getTo()->modify('-1 day');

        $result = Computation::subtraction($april, $subtrahend);
        $this->assertEquals(2, $result->count());
        $this->assertInstanceOf(Creation::class, $result[0]);
        $this->assertInstanceOf(Change::class, $result[1]);
        $this->assertEquals(new \DateTime('2000-04-01 00:00:00'), $april->getFrom());
        $this->assertEquals(new \DateTime('2000-04-01 23:59:59'), $april->getTo());
        $this->assertEquals(new \DateTime('2000-04-30 00:00:00'), $result[0]->getObject()->getFrom());
        $this->assertEquals(new \DateTime('2000-04-30 23:59:59'), $result[0]->getObject()->getTo());
    }

    /**
     * @see Computation::subtraction()
     */
    public function testNoIntersection()
    {
        $april = $this->getAprilPeriod();
        $may = $this->getMayPeriod();
        $this->assertEquals(0, Computation::subtraction($april, $may)->count());
        $this->assertEquals(0, Computation::subtraction($may, $april)->count());
    }

    /**
     * @see Computation::subtraction()
     */
    public function testSubtractLastDay()
    {
        $april = $this->getAprilPeriod();
        $subtrahend = $this->getMayPeriod();
        $subtrahend->getFrom()->modify('-1 day');

        $result = Computation::subtraction($april, $subtrahend);
        $this->assertEquals(1, $result->count());
        $this->assertInstanceOf(Change::class, $result[0]);
        $this->assertEquals(new \DateTime('2000-04-29 23:59:59'), $april->getTo());
    }

    /**
     * @see Computation::subtraction()
     */
    public function testSubtractFirstDay()
    {
        $may = $this->getMayPeriod();
        $subtrahend = $this->getAprilPeriod();
        $subtrahend->getTo()->modify('+1 day');

        $result = Computation::subtraction($may, $subtrahend);
        $this->assertEquals(1, $result->count());
        $this->assertInstanceOf(Change::class, $result[0]);
        $this->assertEquals(new \DateTime('2000-05-02 00:00:00'), $may->getFrom());
    }
}
