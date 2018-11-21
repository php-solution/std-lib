<?php
declare(strict_types=1);

namespace PhpSolution\StdLib\FrequentField\Interfaces;

/**
 * UpdatedAtInterface
 */
interface UpdatedAtInterface
{
    /**
     * @return \DateTime|null
     */
    public function getUpdatedAt():? \DateTime;
}
