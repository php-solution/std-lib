<?php

namespace PhpSolution\StdLib\Enum;

/**
 * Class GenderEnum
 */
class GenderEnum extends AbstractEnum
{
    const MAN = 0;
    const WOMAN = 1;

    /**
     * @return int[]
     */
    public function getAllowedValues()
    {
        return [self::MAN, self::WOMAN];
    }
}