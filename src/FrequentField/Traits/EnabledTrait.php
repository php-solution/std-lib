<?php
namespace PhpSolution\FrequentField\Traits;

use PhpSolution\FrequentField\Interfaces\EnabledInterface;

/**
 * EnabledTrait
 */
trait EnabledTrait
{
    /**
     * @var bool
     */
    protected $enabled = false;

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * @param bool $enabled
     *
     * @return $this
     */
    public function setActive(bool $enabled = EnabledInterface::ENABLED)
    {
        $this->enabled = $enabled;

        return $this;
    }
}