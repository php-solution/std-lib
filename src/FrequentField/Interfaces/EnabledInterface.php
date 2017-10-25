<?php

namespace PhpSolution\StdLib\FrequentField\Interfaces;

/**
 * EnabledInterface
 */
interface EnabledInterface
{
    const DISABLED = false;
    const ENABLED = true;

    /**
     * @return bool
     */
    public function isEnabled(): bool;

    /**
     * @param bool $enabled
     *
     * @return self
     */
    public function setEnabled(bool $enabled);
}