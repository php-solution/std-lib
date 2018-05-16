<?php

namespace Tests\Period\Computation;

use PhpSolution\StdLib\Period\Computation;
use PhpSolution\StdLib\Range\DateTimeRange;

/**
 * @see Computation::truncate()
 */
class TruncateTest extends AbstractComputationTest
{
    /**
     * @see Computation::truncate()
     */
    public function testNoTruncation()
    {
        $april = $this->getAprilPeriod();
        $minuend = $this->getAprilPeriod();
        $to = $this->getAprilPeriod();

        $this->assertEquals(0, Computation::truncate($minuend, $to)->count());
        $this->assertEquals($april->getFrom(), $minuend->getFrom());
        $this->assertEquals($april->getTo(), $minuend->getTo());

        $minuend = $this->getAprilPeriod();
        $to = $this->getAprilPeriod();
        $to->getFrom()->modify('-1 day');
        $to->getTo()->modify('+1 day');

        $this->assertEquals(0, Computation::truncate($minuend, $to)->count());
        $this->assertEquals($april->getFrom(), $minuend->getFrom());
        $this->assertEquals($april->getTo(), $minuend->getTo());
    }

    /**
     * @see Computation::truncate()
     */
    public function testTruncate()
    {
        $minuend = $this->getAprilPeriod();
        $to = $this->getAprilPeriod();
        $to->getFrom()->modify('+1 day');
        $to->getTo()->modify('-1 day');

        $this->assertEquals(1, Computation::truncate($minuend, $to)->count());
        $this->assertEquals($to->getFrom(), $minuend->getFrom());
        $this->assertEquals($to->getTo(), $minuend->getTo());
    }

    /**
     * @see Computation::truncate()
     */
    public function testTruncateInfinity()
    {
        $minuend = new DateTimeRange();
        $to = $this->getAprilPeriod();

        $this->assertEquals(1, Computation::truncate($minuend, $to)->count());
        $this->assertEquals($to->getFrom(), $minuend->getFrom());
        $this->assertEquals($to->getTo(), $minuend->getTo());
    }
}
