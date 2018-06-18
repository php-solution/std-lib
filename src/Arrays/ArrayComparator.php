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
    public function subAssoc(string $key)
    {
        if ($this->checkSubArray($key)) {
            return new StubArrayComparator($this);
        }
        $subComparator = new self($this->actual[$key], $this->expected[$key], $this);
        $this->skip($key);

        return $subComparator;
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
