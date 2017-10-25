<?php

namespace PhpSolution\StdLib\DatePeriod;

/**
 * DatePeriodTrait
 */
trait DatePeriodTrait
{
    /**
     * @var \DateTime|null
     */
    protected $dateStart;
    /**
     * @var \DateTime|null
     */
    protected $dateEnd;

    /**
     * @return \DateTime|null
     */
    public function getDateStart():? \DateTime
    {
        return $this->dateStart;
    }

    /**
     * @param \DateTime|null $dateStart
     *
     * @return $this
     */
    public function setDateStart(\DateTime $dateStart = null)
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getDateEnd():? \DateTime
    {
        return $this->dateEnd;
    }

    /**
     * @param \DateTime|null $dateEnd
     *
     * @return $this
     */
    public function setDateEnd(\DateTime $dateEnd = null)
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }
}