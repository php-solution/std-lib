<?php
namespace PhpSolution\StdLib\Consequence;

/**
 * ObjectConsequenceTrait
 */
trait ObjectConsequenceTrait
{
    /**
     * @var object
     */
    private $object;

    /**
     * @param object $object
     */
    public function __construct($object)
    {
        $this->object = $object;
    }

    /**
     * @return object
     */
    public function getObject()
    {
        return $this->object;
    }
}