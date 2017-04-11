<?php
namespace Tests\DatePeriod\Computation;

use PhpSolution\StdLib\DatePeriod\DatePeriod;
use PhpSolution\StdLib\DatePeriod\DatePeriodFactory;
use PHPUnit\Framework\TestCase;

/**
 * Class AbstractComputationTest
 */
abstract class AbstractComputationTest extends TestCase
{
    /**
     * @return DatePeriod
     */
    protected function getAprilPeriod()
    {
        return DatePeriodFactory::create(2000, 4);
    }

    /**
     * @return DatePeriod
     */
    protected function getMayPeriod()
    {
        return DatePeriodFactory::create(2000, 5);
    }
}