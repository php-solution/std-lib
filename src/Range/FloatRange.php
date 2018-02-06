<?php

namespace PhpSolution\StdLib\Range;

use PhpSolution\StdLib\Object\EmptyInterface;

/**
 * FloatRange
 */
class FloatRange implements RangeInterface, EmptyInterface
{
    /**
     * @var float|null
     */
    private $from;

    /**
     * @var float|null
     */
    private $to;

    /**
     * @return float|null
     */
    public function getFrom(): ?float
    {
        return $this->from;
    }

    /**
     * @param float|null $from
     *
     * @return self
     */
    public function setFrom(?float $from): FloatRange
    {
        $this->from = $from;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getTo(): ?float
    {
        return $this->to;
    }

    /**
     * @param float|null $to
     *
     * @return self
     */
    public function setTo(?float $to): FloatRange
    {
        $this->to = $to;

        return $this;
    }

    /**
     * @return bool
     */
    public function isEmpty(): bool
    {
        return empty($this->from) && empty($this->to);
    }
}
