<?php

namespace Tests\Period;

use PhpSolution\StdLib\Period\PeriodFactory;
use PhpSolution\StdLib\Range\DateTimeRange;
use PHPUnit\Framework\TestCase;

/**
 * @see PeriodFactory
 */
class PeriodFactoryTest extends TestCase
{
    /**
     * @see PeriodFactory::create()
     *
     * @dataProvider createDataProvider
     *
     * @param int           $year
     * @param int|null      $month
     * @param int|null      $day
     * @param DateTimeRange $expectedResult
     */
    public function testCreate(int $year, int $month = null, int $day = null, DateTimeRange $expectedResult)
    {
        $period = PeriodFactory::create($year, $month, $day);
        $this->assertEquals($expectedResult->getFrom(), $period->getFrom());
        $this->assertEquals($expectedResult->getTo(), $period->getTo());
    }

    /**
     * @return array
     */
    public function createDataProvider()
    {
        return [
            [
                'year' => 2017,
                'month' => null,
                'day' => null,
                'expectedResult' => new DateTimeRange(
                    new \DateTime('01.01.2017 00:00:00'),
                    new \DateTime('31.12.2017 23:59:59')
                )
            ],
            [
                'year' => 2017,
                'month' => 6,
                'day' => null,
                'expectedResult' => new DateTimeRange(
                    new \DateTime('01.06.2017 00:00:00'),
                    new \DateTime('30.06.2017 23:59:59')
                )
            ],
            [
                'year' => 2017,
                'month' => 6,
                'day' => 30,
                'expectedResult' => new DateTimeRange(
                    new \DateTime('30.06.2017 00:00:00'),
                    new \DateTime('30.06.2017 23:59:59')
                )
            ],
        ];
    }
}
