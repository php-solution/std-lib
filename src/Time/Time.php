<?php

namespace PhpSolution\StdLib\Time;

/**
 * Time
 */
class Time
{
    /**
     * @var int|null
     */
    private $time;

    /**
     * @param int|null $time
     */
    public function __construct(int $time = null)
    {
        $this->setTime($time);
    }

    /**
     * @return int|null
     */
    public function getTime():? int
    {
        return $this->time;
    }

    /**
     * @param int|null $time
     *
     * @return self
     */
    public function setTime(int $time = null)
    {
        if (null !== $time) {
            $this->validate($time);
        }
        $this->time = $time;

        return $this;
    }

    /**
     * @param int $second
     */
    final private function validate(int $second): void
    {
        if ($second < 0 || $second >= 86400) {
            throw new \RangeException(sprintf(__CLASS__ . ': incorrect value "%s"', $second));
        }
    }

    /**
     * @return int
     */
    public function getHours(): int
    {
        return (int) $this->time / 3600;
    }

    /**
     * @return int
     */
    public function getMinutes(): int
    {
        return ((int) $this->time / 60) % 60;
    }

    /**
     * @return int
     */
    public function getSeconds(): int
    {
        return $this->time % 60;
    }

    /**
     * @param \DateTime $dateTime
     *
     * @return Time
     */
    public static function dateTimeToTime(\DateTime $dateTime): Time
    {
        return self::strToTime($dateTime->format('H:i:s'));
    }

    /**
     * @return Time
     */
    public static function createNow(): Time
    {
        return self::dateTimeToTime(new \DateTime());
    }

        /**
     * @param string $str
     *
     * @return Time
     */
    public static function strToTime(string $str): Time
    {
        $second = 0;
        preg_match('/^(\d+):(\d+)(:(\d+))?$/', $str, $match);
        if (count($match) < 2) {
            throw new \RangeException(sprintf(__CLASS__ . ': impossible parse "%s"', $str));
        }
        $hours = (int) $match[1];
        $minutes = (int) $match[2];
        if ($hours < 0 || $hours >= 24) {
            throw new \RangeException(sprintf(__CLASS__ . ': impossible value "%s" for hours', $hours));
        }
        if ($minutes < 0 || $minutes >= 60) {
            throw new \RangeException(sprintf(__CLASS__ . ': impossible value "%s" for minutes', $minutes));
        }
        $second += 3600 * $hours + 60 * $minutes;
        if (array_key_exists(4, $match)) {
            $seconds = $match[4];
            if ($seconds < 0 || $seconds >= 60) {
                throw new \RangeException(sprintf(__CLASS__ . ': impossible value "%s" for seconds', $seconds));
            }
            $second += $seconds;
        }

        return new Time($second);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return sprintf("%'.02d:%'.02d:%'.02d", $this->getHours(), $this->getMinutes(), $this->getSeconds());
    }
}