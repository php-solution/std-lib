<?php

namespace PhpSolution\StdLib\Range;

use PhpSolution\StdLib\Period\PeriodInterface;
use PhpSolution\StdLib\Object\EmptyInterface;

/**
 * DateTimeRange
 */
class DateTimeRange implements PeriodInterface, EmptyInterface
{
    /**
     * @var \DateTime|null
     */
    private $from;

    /**
     * @var \DateTime|null
     */
    private $to;

    /**
     * @param \DateTime|null $from
     * @param \DateTime|null $to
     */
    public function __construct(\DateTime $from = null, \DateTime $to = null)
    {
        $this->from = $from;
        $this->to = $to;
    }

    /**
     * @return \DateTime|null
     */
    public function getFrom(): ?\DateTime
    {
        return $this->from;
    }

    /**
     * @param \DateTime|null $from
     *
     * @return self
     */
    public function setFrom(?\DateTime $from): self
    {
        $this->from = $from;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getTo(): ?\DateTime
    {
        return $this->to;
    }

    /**
     * @param \DateTime|null $to
     *
     * @return DateTimeRange
     */
    public function setTo(?\DateTime $to): self
    {
        $this->to = $to;

        return $this;
    }

    /**
     * @return bool
     */
    public function isEmpty(): bool
    {
        return null === $this->from && null === $this->to;
    }

    /**
     * Clone DateTimeRange with internal objects
     */
    public function __clone()
    {
        if (null !== ($from = $this->getFrom())) {
            $this->setFrom(clone $from);
        }
        if (null !== ($to = $this->getTo()) ) {
            $this->setTo(clone $to);
        }
    }
}
