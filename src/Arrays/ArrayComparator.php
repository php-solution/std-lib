<?php
declare(strict_types=1);

namespace PhpSolution\StdLib\Arrays;

/**
 * ArrayComparator
 */
class ArrayComparator
{
    /**
     * @var array
     */
    private $expected;

    /**
     * @var array
     */
    private $actual;

    /**
     * @var ArrayComparator|null
     */
    private $parent;

    /**
     * @var bool
     */
    private $result = true;

    /**
     * @param array                $expected
     * @param array                $actual
     * @param null|ArrayComparator $parent
     */
    public function __construct(array $expected, array $actual, ArrayComparator $parent = null)
    {
        $this->expected = $expected;
        $this->actual = $actual;
        $this->parent = $parent;
    }

    /**
     * @return bool|self
     */
    public function compare()
    {
        if ($this->result) {
            $this->result = $this->checkEquality();
        }

        if (null === $this->parent) {
            return $this->result;
        } else {
            if (!$this->result) {
                $this->parent->fail();
            }

            return $this->parent;
        }
    }

    /**
     * @return self
     */
    public function fail(): self
    {
        $this->result = false;

        return $this;
    }

    /**
     * @param string $key
     * @param int    $precision
     *
     * @return ArrayComparator
     */
    public function float(string $key, int $precision = 2): self
    {
        if (array_key_exists($key, $this->actual) && array_key_exists($key, $this->expected)) {
            $actual = (int) ($this->actual[$key] * pow(10, $precision));
            $expected = (int) ($this->expected[$key] * pow(10, $precision));
            if ($actual !== $expected) {
                $this->fail();
            }
            $this->skip($key);
        }

        return $this;
    }

    /**
     * @param string $key
     *
     * @return self
     */
    public function skip(string $key): self
    {
        unset($this->expected[$key], $this->actual[$key]);

        return $this;
    }

    /**
     * @return self
     */
    public function skipNulls(): self
    {
        foreach ($this->expected as $key => $value) {
            if (null === $value) {
                unset($this->expected[$key]);
            }
        }
        foreach ($this->actual as $key => $value) {
            if (null === $value) {
                unset($this->actual[$key]);
            }
        }

        return $this;
    }

    /**
     * @param string $key
     *
     * @return self
     */
    public function subArray(string $key): self
    {
        if (!$this->result || $this->checkSubArray($key)) {
            return $this;
        }
        if (
            count(array_diff($this->expected[$key], $this->actual[$key])) > 0 ||
            count(array_diff($this->actual[$key], $this->expected[$key])) > 0
        ) {
            $this->result = false;
        }
        $this->skip($key);

        return $this;
    }

    /**
     * @param string $key
     *
     * @return self|StubArrayComparator
     */
    public function subObject(string $key)
    {
        if (!$this->result || $this->checkSubArray($key)) {
            return new StubArrayComparator($this);
        }
        $subComparator = new self($this->actual[$key], $this->expected[$key], $this);
        $this->skip($key);

        return $subComparator;
    }

    /**
     * @param string        $key
     * @param \Closure|null $comparisonFoo
     *
     * @return ArrayComparator
     */
    public function subArrayOfObject(string $key, \Closure $comparisonFoo = null): self
    {
        if (!$this->result || $this->checkSubArray($key)) {
            return $this;
        }
        if (count($this->actual[$key]) !== count($this->expected[$key])) {
            $this->fail();

            return $this;
        }

        $comparisonFoo = null !== $comparisonFoo ? $comparisonFoo : function (array $actual, array $expected) {
            return $actual == $expected;
        };

        foreach ($this->actual[$key] as $i => $item) {
            if (array_key_exists($i, $this->expected[$key])) {
                if ($comparisonFoo($this->actual[$key][$i], $this->expected[$key][$i])) {
                    continue;
                }
            }

            $this->fail();

            return $this;
        }

        return $this;
    }

    /**
     * @return bool
     */
    private function checkEquality(): bool
    {
        return $this->actual == $this->expected;
    }

    /**
     * @param string $key
     *
     * @return bool if true, it means no need to continue comparison
     */
    private function checkSubArray(string $key): bool
    {
        if (!array_key_exists($key, $this->expected) && !array_key_exists($key, $this->actual)) {
            return true;
        }

        if (!array_key_exists($key, $this->expected) || !array_key_exists($key, $this->actual)) {
            $this->result = false;

            return true;
        }

        if (null === $this->expected[$key] && null === $this->actual[$key]) {
            return true;
        }

        if (!is_array($this->expected[$key]) || !is_array($this->actual[$key])) {
            $this->result = false;

            return true;
        }

        return false;
    }
}
