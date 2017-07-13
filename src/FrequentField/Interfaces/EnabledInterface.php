<?php
namespace PhpSolution\FrequentField\Interfaces;

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
}