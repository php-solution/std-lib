<?php

namespace PhpSolution\StdLib\Range;

use PhpSolution\StdLib\Object\EmptyInterface;

/**
 * IntRange
 */
class IntRange implements RangeInterface, EmptyInterface
{
    /**
     * @var int|null
     */
    private $from;

    /**
     * @var int|null
     */
    private $to;

    /**
     * @return int|null
     */
    public function getFrom(): ?int
    {
        return $this->from;
    }

    /**
     * @param int|null $from
     *
     * @return self
     */
    public function setFrom(?int $from): IntRange
    {
        $this->from = $from;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getTo(): ?int
    {
        return $this->to;
    }

    /**
     * @param int|null $to
     *
     * @return self
     */
    public function setTo(?int $to): IntRange
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
