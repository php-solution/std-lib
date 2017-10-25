<?php

namespace PhpSolution\StdLib\FrequentField\Traits;

/**
 * NameTrait
 */
trait NameTrait
{
    /**
     * @var null|string
     */
    protected $name;

    /**
     * @return null|string
     */
    public function getName():? string
    {
        return $this->name;
    }

    /**
     * @param null|string $name
     *
     * @return $this
     */
    public function setName(string $name = null)
    {
        $this->name = $name;

        return $this;
    }
}