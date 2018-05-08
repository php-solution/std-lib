<?php

namespace PhpSolution\StdLib\Range;

use PhpSolution\StdLib\Object\EmptyInterface;

/**
 * DateTimeRange
 */
class DateTimeRange implements RangeInterface, EmptyInterface
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
     * @return \DateTime|null
     */
    public function getFrom(): ?\DateTime
    {
        if (\is_string($this->from)) {
            return new \DateTime($this->from);
        }

        return $this->from;
    }

    /**
     * @param \DateTime|null $from
     *
     * @return DateTimeRange
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
        if (\is_string($this->to)) {
            return new \DateTime($this->to);
        }

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
}
