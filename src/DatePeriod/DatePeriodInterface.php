<?php

namespace PhpSolution\StdLib\DatePeriod;

/**
 * DatePeriodInterface
 */
interface DatePeriodInterface
{
    /**
     * @return \DateTime|null
     */
    public function getDateStart():? \DateTime;

    /**
     * @param \DateTime|null $dateStart
     *
     * @return $this
     */
    public function setDateStart(\DateTime $dateStart = null);

    /**
     * @return \DateTime|null
     */
    public function getDateEnd():? \DateTime;

    /**
     * @param \DateTime|null $dateEnd
     *
     * @return $this
     */
    public function setDateEnd(\DateTime $dateEnd = null);
}