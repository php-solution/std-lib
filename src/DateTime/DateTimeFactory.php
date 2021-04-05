<?php

declare(strict_types=1);

namespace PhpSolution\StdLib\DateTime;

class DateTimeFactory
{
    public const TYPE_PERIOD = 'PERIOD';
    public const TYPE_DAILY = 'DAILY';

    /**
     * Method will set time for dateTime object, time should be greater then $greaterThen object
     * If type is period it will set next possible slot. Example if now 01:00 and time is 3600 it will set 02:00
     * If type is daily it will set next possible slot. Example if now 01:00 and time is 7 * 3600 it will set 07:00
     *
     * @param string    $type
     * @param int       $time
     * @param \DateTime $dateTime
     * @param \DateTime $greaterThen
     *
     * @return \DateTime
     */
    public function setNextTime(string $type, int $time, \DateTime $dateTime, \DateTime $greaterThen): \DateTime
    {
        if ($dateTime === $greaterThen) {
            $greaterThen = clone $dateTime;
        }

        if (self::TYPE_PERIOD === $type) {
            $inc = $time;
            $now = 0;
            $dateTime->setTime(0, 0, 0);
        } else {
            $inc = 24 * 60 * 60;
            $now = $time;
            $this->setTime($dateTime, $time);
        }

        while ($dateTime <= $greaterThen) {
            $now += $inc;
            $dateTime->modify(sprintf('+%d seconds', $inc));

            switch ($type)
            {
                case self::TYPE_PERIOD:
                    $this->setTime($dateTime, $now);
                    break;
                case self::TYPE_DAILY:
                    $this->setTime($dateTime, $time);
                    break;
            }
        }

        return $dateTime;
    }

    private function setTime(\DateTime $dateTime, int $time): void
    {
        $dateTime->setTime($time / 3600 % 24, $time / 60 % 60, $time % 60);
    }
}