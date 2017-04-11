<?php
namespace PhpSolution\StdLib\DatePeriod;

/**
 * DatePeriod store inside 2 dates (including from and including to). So DatePeriod for whole 2017 year will have:
 * start date "01.01.2017 00:00:00", end date "31.12.2017 23:59:59"
 */
class DatePeriod implements DatePeriodInterface
{
    use DatePeriodTrait;

    /**
     * @param \DateTime|null $start
     * @param \DateTime|null $end
     */
    public function __construct(\DateTime $start = null, \DateTime $end = null)
    {
        $this->setDateStart($start);
        $this->setDateEnd($end);
    }

    /**
     * Clone Date period with internal objects
     */
    public function __clone()
    {
        if (($start = $this->getDateStart()) !== null) {
            $this->setDateStart(clone $start);
        }
        if (($end = $this->getDateEnd()) !== null) {
            $this->setDateEnd(clone $end);
        }
    }
}