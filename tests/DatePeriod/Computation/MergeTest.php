<?php
namespace Tests\DatePeriod\Computation;

use PhpSolution\StdLib\Consequence\Change;
use PhpSolution\StdLib\Consequence\ConsequenceCollection;
use PhpSolution\StdLib\Consequence\Destruction;
use PhpSolution\StdLib\DatePeriod\Computation;
use PhpSolution\StdLib\DatePeriod\DatePeriod;

/**
 * @see \PhpSolution\StdLib\DatePeriod\Computation::merge()
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
     * @see \PhpSolution\StdLib\DatePeriod\Computation::merge()
     */
    public function testNoIntersection()
    {
        $april = $this->getAprilPeriod();
        $may = $this->getMayPeriod();
        $may->getDateStart()->modify('+1 day');

        $this->assertEquals(0, Computation::merge($april, $may)->count());
        $this->assertEquals(0, Computation::merge($may, $april)->count());
    }

    /**
     * @see \PhpSolution\StdLib\DatePeriod\Computation::merge()
     */
    public function testLeftMerge()
    {
        $april = $this->getAprilPeriod();
        $may = $this->getMayPeriod();

        $this->assertMergedAndChanged(Computation::merge($april, $may));
        $this->assertEquals($this->getAprilPeriod()->getDateStart(), $april->getDateStart());
        $this->assertEquals($this->getMayPeriod()->getDateEnd(), $april->getDateEnd());
    }

    /**
     * @see \PhpSolution\StdLib\DatePeriod\Computation::merge()
     */
    public function testRightMerge()
    {
        $april = $this->getAprilPeriod();
        $may = $this->getMayPeriod();

        $this->assertMergedAndChanged(Computation::merge($may, $april));
        $this->assertEquals($this->getAprilPeriod()->getDateStart(), $may->getDateStart());
        $this->assertEquals($this->getMayPeriod()->getDateEnd(), $may->getDateEnd());
    }

    /**
     * @see \PhpSolution\StdLib\DatePeriod\Computation::merge()
     */
    public function testSameMerge()
    {
        $april = $this->getAprilPeriod();

        $this->assertMergedNotChanged(Computation::merge($april, $this->getAprilPeriod()));
        $this->assertEquals($this->getAprilPeriod()->getDateStart(), $april->getDateStart());
        $this->assertEquals($this->getAprilPeriod()->getDateEnd(), $april->getDateEnd());
    }

    /**
     * @see \PhpSolution\StdLib\DatePeriod\Computation::merge()
     */
    public function testInsideMerge()
    {
        $april = $this->getAprilPeriod();
        $inside = $this->getAprilPeriod();
        $inside->getDateStart()->modify('+1 day');
        $inside->getDateEnd()->modify('-1 day');

        $this->assertMergedNotChanged(Computation::merge($april, $inside));
        $this->assertEquals($this->getAprilPeriod()->getDateStart(), $april->getDateStart());
        $this->assertEquals($this->getAprilPeriod()->getDateEnd(), $april->getDateEnd());
    }

    /**
     * @see \PhpSolution\StdLib\DatePeriod\Computation::merge()
     */
    public function testOutsideMerge()
    {
        $april = $this->getAprilPeriod();
        $outside = $this->getAprilPeriod();
        $outside->getDateStart()->modify('-1 day');
        $outside->getDateEnd()->modify('+1 day');

        $this->assertMergedAndChanged(Computation::merge($april, $outside));
        $this->assertEquals($outside->getDateStart(), $april->getDateStart());
        $this->assertEquals($outside->getDateEnd(), $april->getDateEnd());
    }

    /**
     * @see \PhpSolution\StdLib\DatePeriod\Computation::merge()
     */
    public function testAInfinite()
    {
        $a = new DatePeriod();
        $b = $this->getAprilPeriod();
        $this->assertMergedNotChanged(Computation::merge($a, $b));
        $this->assertEquals(null, $a->getDateStart());
        $this->assertEquals(null, $a->getDateEnd());
    }

    /**
     * @see \PhpSolution\StdLib\DatePeriod\Computation::merge()
     */
    public function testBInfinite()
    {
        $a = $this->getAprilPeriod();
        $b = new DatePeriod();
        $this->assertMergedAndChanged(Computation::merge($a, $b));
        $this->assertEquals(null, $a->getDateStart());
        $this->assertEquals(null, $a->getDateEnd());
    }
}