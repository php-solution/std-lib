<?php
namespace PhpSolution\StdLib\FrequentField\Traits;

/**
 * UpdatedAtTrait
 */
trait UpdatedAtTrait
{
    /**
     * @var \DateTime|null
     */
    protected $updatedAt;

    /**
     * @return \DateTime|null
     */
    public function getUpdatedAt():? \DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     *
     * @return $this
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}