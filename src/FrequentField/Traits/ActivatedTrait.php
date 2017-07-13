<?php
namespace PhpSolution\FrequentField\Traits;

use PhpSolution\FrequentField\Interfaces\ActivatedInterface;

/**
 * ActivatedTrait
 */
trait ActivatedTrait
{
    /**
     * @var bool
     */
    protected $active = false;

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * @param bool $active
     *
     * @return $this
     */
    public function setActive(bool $active = ActivatedInterface::ACTIVATED)
    {
        $this->active = $active;

        return $this;
    }
}