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
    protected function getType(): string
    {
        return ConsequenceInterface::class;
    }
}