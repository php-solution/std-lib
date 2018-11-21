<?php
declare(strict_types=1);

namespace PhpSolution\StdLib\FrequentField\Interfaces;

/**
 * CreatedAtInterface
 */
interface CreatedAtInterface
{
    /**
     * @return \DateTime|null
     */
    public function getCreatedAt():? \DateTime;
}
