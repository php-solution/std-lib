<?php

namespace Tests\Period\Computation;

use PhpSolution\StdLib\Period\PeriodFactory;
use PhpSolution\StdLib\Range\DateTimeRange;
use PHPUnit\Framework\TestCase;

/**
 * AbstractComputationTest
 */
abstract class AbstractComputationTest extends TestCase
{
    /**
     * @return DateTimeRange
     */
    protected function getAprilPeriod(): DateTimeRange
    {
        return PeriodFactory::create(2000, 4);
    }

    /**
     * @return DateTimeRange
     */
    protected function getMayPeriod(): DateTimeRange
    {
        return PeriodFactory::create(2000, 5);
    }
}
