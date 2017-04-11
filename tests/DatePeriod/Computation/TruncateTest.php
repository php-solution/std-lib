<?php
namespace Tests\DatePeriod\Computation;

use PhpSolution\StdLib\DatePeriod\Computation;
use PhpSolution\StdLib\DatePeriod\DatePeriod;

/**
 * @see \PhpSolution\StdLib\DatePeriod\Computation::truncate()
 */
class TruncateTest extends AbstractComputationTest
{
    /**
     * @see \PhpSolution\StdLib\DatePeriod\Computation::truncate()
     */
    public function testNoTruncation()
    {
        $april = $this->getAprilPeriod();
        $minuend = $this->getAprilPeriod();
        $to = $this->getAprilPeriod();

        $this->assertEquals(0, Computation::truncate($minuend, $to)->count());
        $this->assertEquals($april->getDateStart(), $minuend->getDateStart());
        $this->assertEquals($april->getDateEnd(), $minuend->getDateEnd());

        $minuend = $this->getAprilPeriod();
        $to = $this->getAprilPeriod();
        $to->getDateStart()->modify('-1 day');
        $to->getDateEnd()->modify('+1 day');

        $this->assertEquals(0, Computation::truncate($minuend, $to)->count());
        $this->assertEquals($april->getDateStart(), $minuend->getDateStart());
        $this->assertEquals($april->getDateEnd(), $minuend->getDateEnd());
    }

    /**
     * @see \PhpSolution\StdLib\DatePeriod\Computation::truncate()
     */
    public function testTruncate()
    {
        $minuend = $this->getAprilPeriod();
        $to = $this->getAprilPeriod();
        $to->getDateStart()->modify('+1 day');
        $to->getDateEnd()->modify('-1 day');

        $this->assertEquals(1, Computation::truncate($minuend, $to)->count());
        $this->assertEquals($to->getDateStart(), $minuend->getDateStart());
        $this->assertEquals($to->getDateEnd(), $minuend->getDateEnd());
    }

    /**
     * @see \PhpSolution\StdLib\DatePeriod\Computation::truncate()
     */
    public function testTruncateInfinity()
    {
        $minuend = new DatePeriod();
        $to = $this->getAprilPeriod();

        $this->assertEquals(1, Computation::truncate($minuend, $to)->count());
        $this->assertEquals($to->getDateStart(), $minuend->getDateStart());
        $this->assertEquals($to->getDateEnd(), $minuend->getDateEnd());
    }
}