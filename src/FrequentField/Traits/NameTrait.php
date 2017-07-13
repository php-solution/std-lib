<?php
namespace PhpSolution\Doctrine\Entity;

/**
 * NameTrait
 */
trait NameTrait
{
    /**
     * @var string
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
     * @param string $name
     *
     * @return $this
     */
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }
}