<?php

namespace PhpSolution\StdLib\Period;

use PhpSolution\StdLib\Range\RangeInterface;

/**
 * PeriodInterface
 */
interface PeriodInterface extends RangeInterface
{
    /**
     * @return \DateTime|null
     */
    public function getFrom(): ?\DateTime;

    /**
     * @param \DateTime|null $from
     *
     * @return self
     */
    public function setFrom(?\DateTime $from);

    /**
     * @return \DateTime|null
     */
    public function getTo(): ?\DateTime;

    /**
     * @param \DateTime|null $dateEnd
     *
     * @return self
     */
    public function setTo(?\DateTime $dateEnd);
}
