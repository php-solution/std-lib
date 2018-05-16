<?php

namespace Tests\Period\Computation;

use PhpSolution\StdLib\Consequence\Change;
use PhpSolution\StdLib\Consequence\ConsequenceCollection;
use PhpSolution\StdLib\Consequence\Destruction;
use PhpSolution\StdLib\Period\Computation;
use PhpSolution\StdLib\Range\DateTimeRange;

/**
 * @see Computation::merge()
 */
class MergeTest extends AbstractComputationTest
{
    /**
     * @param ConsequenceCollection $collection
     */
    private function assertMergedAndChanged(ConsequenceCollection $collection): void
    {
        $this->assertEquals(2, $collection->count());
        $this->assertInstanceOf(Destruction::class, $collection[0]);
        $this->assertInstanceOf(Change::class, $collection[1]);
    }

    /**
     * @param ConsequenceCollection $collection
     */
    private function assertMergedNotChanged(ConsequenceCollection $collection): void
    {
        $this->assertEquals(1, $collection->count());
        $this->assertInstanceOf(Destruction::class, $collection[0]);
    }

    /**
     * @see Computation::merge()
     */
    public function testNoIntersection()
    {
        $april = $this->getAprilPeriod();
        $may = $this->getMayPeriod();
        $may->getFrom()->modify('+1 day');

        $this->assertEquals(0, Computation::merge($april, $may)->count());
        $this->assertEquals(0, Computation::merge($may, $april)->count());
    }

    /**
     * @see Computation::merge()
     */
    public function testLeftMerge()
    {
        $april = $this->getAprilPeriod();
        $may = $this->getMayPeriod();

        $this->assertMergedAndChanged(Computation::merge($april, $may));
        $this->assertEquals($this->getAprilPeriod()->getFrom(), $april->getFrom());
        $this->assertEquals($this->getMayPeriod()->getTo(), $april->getTo());
    }

    /**
     * @see Computation::merge()
     */
    public function testRightMerge()
    {
        $april = $this->getAprilPeriod();
        $may = $this->getMayPeriod();

        $this->assertMergedAndChanged(Computation::merge($may, $april));
        $this->assertEquals($this->getAprilPeriod()->getFrom(), $may->getFrom());
        $this->assertEquals($this->getMayPeriod()->getTo(), $may->getTo());
    }

    /**
     * @see Computation::merge()
     */
    public function testSameMerge()
    {
        $april = $this->getAprilPeriod();

        $this->assertMergedNotChanged(Computation::merge($april, $this->getAprilPeriod()));
        $this->assertEquals($this->getAprilPeriod()->getFrom(), $april->getFrom());
        $this->assertEquals($this->getAprilPeriod()->getTo(), $april->getTo());
    }

    /**
     * @see Computation::merge()
     */
    public function testInsideMerge()
    {
        $april = $this->getAprilPeriod();
        $inside = $this->getAprilPeriod();
        $inside->getFrom()->modify('+1 day');
        $inside->getTo()->modify('-1 day');

        $this->assertMergedNotChanged(Computation::merge($april, $inside));
        $this->assertEquals($this->getAprilPeriod()->getFrom(), $april->getFrom());
        $this->assertEquals($this->getAprilPeriod()->getTo(), $april->getTo());
    }

    /**
     * @see Computation::merge()
     */
    public function testOutsideMerge()
    {
        $april = $this->getAprilPeriod();
        $outside = $this->getAprilPeriod();
        $outside->getFrom()->modify('-1 day');
        $outside->getTo()->modify('+1 day');

        $this->assertMergedAndChanged(Computation::merge($april, $outside));
        $this->assertEquals($outside->getFrom(), $april->getFrom());
        $this->assertEquals($outside->getTo(), $april->getTo());
    }

    /**
     * @see Computation::merge()
     */
    public function testAInfinite()
    {
        $a = new DateTimeRange();
        $b = $this->getAprilPeriod();
        $this->assertMergedNotChanged(Computation::merge($a, $b));
        $this->assertEquals(null, $a->getFrom());
        $this->assertEquals(null, $a->getTo());
    }

    /**
     * @see Computation::merge()
     */
    public function testBInfinite()
    {
        $a = $this->getAprilPeriod();
        $b = new DateTimeRange();
        $this->assertMergedAndChanged(Computation::merge($a, $b));
        $this->assertEquals(null, $a->getFrom());
        $this->assertEquals(null, $a->getTo());
    }
}
