<?php

namespace PhpSolution\StdLib\Period;

use PhpSolution\StdLib\Range\DateTimeRange;

/**
 * PeriodFactory gives ability to create DatePeriod in simple way
 */
class PeriodFactory
{
    /**
     * @param int      $year
     * @param int|null $month
     * @param int|null $day
     *
     * @return DateTimeRange
     */
    public static function create(int $year, int $month = null, int $day = null): DateTimeRange
    {
        $start = (new \DateTime())
            ->setDate($year, $month ?: 1, $day ?: 1)
            ->setTime(0, 0, 0);

        $end = clone $start;

        switch (true) {
            case null === $month:
                $end->modify('next year');
                break;
            case null === $day:
                $end->modify('next month');
                break;
            default:
                $end->modify('next day');
        }
        $end->modify('-1 second');

        return new DateTimeRange($start, $end);
    }
}
