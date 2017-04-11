<?php
namespace Tests\DatePeriod\Computation;

use PhpSolution\StdLib\Consequence\Change;
use PhpSolution\StdLib\Consequence\Creation;
use PhpSolution\StdLib\Consequence\Destruction;
use PhpSolution\StdLib\DatePeriod\Computation;

/**
 * @see \PhpSolution\StdLib\DatePeriod\Computation::subtraction()
 */
class SubtractionTest extends AbstractComputationTest
{
    /**
     * @see \PhpSolution\StdLib\DatePeriod\Computation::subtraction()
     */
    public function testDestruction()
    {
        $april = $this->getAprilPeriod();

        $result = Computation::subtraction($april, $april);
        $this->assertEquals(1, $result->count());
        $this->assertInstanceOf(Destruction::class, $result[0]);
    }

    /**
     * @see \PhpSolution\StdLib\DatePeriod\Computation::subtraction()
     */
    public function testLeftFirstDay()
    {
        $april = $this->getAprilPeriod();
        $subtrahend = $this->getAprilPeriod();
        $subtrahend->getDateStart()->modify('+1 day');

        $result = Computation::subtraction($april, $subtrahend);
        $this->assertEquals(1, $result->count());
        $this->assertInstanceOf(Change::class, $result[0]);
        $this->assertEquals(new \DateTime('2000-04-01 00:00:00'), $april->getDateStart());
        $this->assertEquals(new \DateTime('2000-04-01 23:59:59'), $april->getDateEnd());
    }

    /**
     * @see \PhpSolution\StdLib\DatePeriod\Computation::subtraction()
     */
    public function testLeftLastDay()
    {
        $april = $this->getAprilPeriod();
        $subtrahend = $this->getAprilPeriod();
        $subtrahend->getDateEnd()->modify('-1 day');

        $result = Computation::subtraction($april, $subtrahend);
        $this->assertEquals(1, $result->count());
        $this->assertInstanceOf(Change::class, $result[0]);
        $this->assertEquals(new \DateTime('2000-04-30 00:00:00'), $april->getDateStart());
        $this->assertEquals(new \DateTime('2000-04-30 23:59:59'), $april->getDateEnd());
    }

    /**
     * @see \PhpSolution\StdLib\DatePeriod\Computation::subtraction()
     */
    public function testLeftLastAndFirstDay()
    {
        $april = $this->getAprilPeriod();
        $subtrahend = $this->getAprilPeriod();
        $subtrahend->getDateStart()->modify('+1 day');
        $subtrahend->getDateEnd()->modify('-1 day');

        $result = Computation::subtraction($april, $subtrahend);
        $this->assertEquals(2, $result->count());
        $this->assertInstanceOf(Creation::class, $result[0]);
        $this->assertInstanceOf(Change::class, $result[1]);
        $this->assertEquals(new \DateTime('2000-04-01 00:00:00'), $april->getDateStart());
        $this->assertEquals(new \DateTime('2000-04-01 23:59:59'), $april->getDateEnd());
        $this->assertEquals(new \DateTime('2000-04-30 00:00:00'), $result[0]->getObject()->getDateStart());
        $this->assertEquals(new \DateTime('2000-04-30 23:59:59'), $result[0]->getObject()->getDateEnd());
    }

    /**
     * @see \PhpSolution\StdLib\DatePeriod\Computation::subtraction()
     */
    public function testNoIntersection()
    {
        $april = $this->getAprilPeriod();
        $may = $this->getMayPeriod();
        $this->assertEquals(0, Computation::subtraction($april, $may)->count());
        $this->assertEquals(0, Computation::subtraction($may, $april)->count());
    }

    /**
     * @see \PhpSolution\StdLib\DatePeriod\Computation::subtraction()
     */
    public function testSubtractLastDay()
    {
        $april = $this->getAprilPeriod();
        $subtrahend = $this->getMayPeriod();
        $subtrahend->getDateStart()->modify('-1 day');

        $result = Computation::subtraction($april, $subtrahend);
        $this->assertEquals(1, $result->count());
        $this->assertInstanceOf(Change::class, $result[0]);
        $this->assertEquals(new \DateTime('2000-04-29 23:59:59'), $april->getDateEnd());
    }

    /**
     * @see \PhpSolution\StdLib\DatePeriod\Computation::subtraction()
     */
    public function testSubtractFirstDay()
    {
        $may = $this->getMayPeriod();
        $subtrahend = $this->getAprilPeriod();
        $subtrahend->getDateEnd()->modify('+1 day');

        $result = Computation::subtraction($may, $subtrahend);
        $this->assertEquals(1, $result->count());
        $this->assertInstanceOf(Change::class, $result[0]);
        $this->assertEquals(new \DateTime('2000-05-02 00:00:00'), $may->getDateStart());
    }
}