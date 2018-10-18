<?php
declare(strict_types=1);

namespace PhpSolution\StdLib\Arrays;

/**
 * StubArrayComparator
 */
class StubArrayComparator
{
    /**
     * @var ArrayComparator|StubArrayComparator
     */
    private $parent;

    /**
     * @param ArrayComparator|StubArrayComparator $parent
     */
    public function __construct($parent)
    {
        $this->parent = $parent;
    }

    /**
     * @return ArrayComparator|StubArrayComparator
     */
    public function compare()
    {
        return $this->parent;
    }

    /**
     * @return self
     */
    public function fail(): self
    {
        return $this;
    }

    /**
     * @return self
     */
    public function float(): self
    {
        return $this;
    }

    /**
     * @param string $key
     *
     * @return self
     */
    public function skip(string $key): self
    {
        return $this;
    }

    /**
     * @return self
     */
    public function skipNulls(): self
    {
        return $this;
    }

    /**
     * @param string $key
     *
     * @return self
     */
    public function subArray(string $key): self
    {
        return $this;
    }

    /**
     * @param string $key
     *
     * @return ArrayComparator|StubArrayComparator
     */
    public function subAssoc(string $key): self
    {
        return new StubArrayComparator($this);
    }
}
