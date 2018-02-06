<?php

namespace Tests\Mapper;

/**
 * MappedData
 */
class MappedData
{
    /**
     * @var int
     */
    public $array2 = [1];
    /**
     * @var int
     */
    private $scalar1 = 2;
    /**
     * @var bool
     */
    private $scalar2 = true;

    /**
     * @return int
     */
    public function getScalar1(): int
    {
        return $this->scalar1;
    }

    /**
     * @param int $scalar1
     */
    public function setScalar1(int $scalar1)
    {
        $this->scalar1 = $scalar1;
    }

    /**
     * @return bool
     */
    public function isScalar2(): bool
    {
        return $this->scalar2;
    }

    /**
     * @param bool $scalar2
     */
    public function setScalar2(bool $scalar2)
    {
        $this->scalar2 = $scalar2;
    }
}
