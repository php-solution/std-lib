<?php

namespace Tests\Mapper;

use PhpSolution\StdLib\Collection\GenericCollection;
use PhpSolution\StdLib\DatePeriod\DatePeriod;

/**
 * MappedObject
 */
class MappedObject
{
    /**
     * @var object
     */
    public $subObject1;
    /**
     * @var object
     */
    private $subObject2;
    /**
     * @var GenericCollection
     */
    public $generic1;
    /**
     * @var GenericCollection
     */
    private $generic2;
    /**
     * @var array
     */
    public $array1;
    /**
     * @var array
     */
    private $array2;
    /**
     * @var int
     */
    public $scalar1;
    /**
     * @var bool
     */
    private $scalar2;

    /**
     * MappedObject constructor
     */
    public function __construct()
    {
        $this->subObject1 = (object) ['a' => null, 'b' => null];
        $this->subObject2 = (object) ['a' => null, 'b' => null];
        $this->generic1 = new GenericCollection(\DateTime::class);
        $this->generic2 = new GenericCollection(DatePeriod::class);
    }

    /**
     * @return object
     */
    public function getSubObject2()
    {
        return $this->subObject2;
    }

    /**
     * @param object $subObject2
     */
    public function setSubObject2(object $subObject2)
    {
        $this->subObject2 = $subObject2;
    }

    /**
     * @return GenericCollection
     */
    public function getGeneric2(): GenericCollection
    {
        return $this->generic2;
    }

    /**
     * @param GenericCollection $generic2
     */
    public function setGeneric2(GenericCollection $generic2)
    {
        $this->generic2 = $generic2;
    }

    /**
     * @return array
     */
    public function getArray2()
    {
        return $this->array2;
    }

    /**
     * @param array $array2
     */
    public function setArray2(array $array2)
    {
        $this->array2 = $array2;
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
