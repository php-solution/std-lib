<?php
namespace PhpSolution\StdLib\Consequence;

use PhpSolution\StdLib\Collection\AbstractGenericCollection;

/**
 * Class ConsequenceCollection
 */
class ConsequenceCollection extends AbstractGenericCollection
{
    /**
     * @return string
     */
    public function getType(): string
    {
        return ConsequenceInterface::class;
    }
}