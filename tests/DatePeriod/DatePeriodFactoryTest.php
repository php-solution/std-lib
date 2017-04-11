<?php
namespace Tests\DatePeriod;

use PhpSolution\StdLib\DatePeriod\DatePeriod;
use PhpSolution\StdLib\DatePeriod\DatePeriodFactory;
use PHPUnit\Framework\TestCase;

/**
 * @see \PhpSolution\StdLib\DatePeriod\DatePeriodFactory
 */
class DatePeriodFactoryTest extends TestCase
{
    /**
     * @see \PhpSolution\StdLib\DatePeriod\DatePeriodFactory::create()
     *
     * @param int      $year
     * @param int|null $month
     * @param int|null $day
     *
     * @param DatePeriod $expectedResult
     *
     * @dataProvider createDataProvider
     */
    public function testCreate(int $year, int $month = null, int $day = null, DatePeriod $expectedResult)
    {
        $period = DatePeriodFactory::create($year, $month, $day);
        $this->assertEquals($expectedResult->getDateStart(), $period->getDateStart());
        $this->assertEquals($expectedResult->getDateEnd(), $period->getDateEnd());
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
                'expectedResult' => new DatePeriod(
                    new \DateTime('01.01.2017 00:00:00'),
                    new \DateTime('31.12.2017 23:59:59')
                )
            ],
            [
                'year' => 2017,
                'month' => 6,
                'day' => null,
                'expectedResult' => new DatePeriod(
                    new \DateTime('01.06.2017 00:00:00'),
                    new \DateTime('30.06.2017 23:59:59')
                )
            ],
            [
                'year' => 2017,
                'month' => 6,
                'day' => 30,
                'expectedResult' => new DatePeriod(
                    new \DateTime('30.06.2017 00:00:00'),
                    new \DateTime('30.06.2017 23:59:59')
                )
            ],
        ];
    }
}