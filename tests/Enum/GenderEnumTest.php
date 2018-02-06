<?php

namespace Tests\Enum;

use PhpSolution\StdLib\Enum\GenderEnum;
use PHPUnit\Framework\TestCase;

/**
 * @see GenderEnum
 */
class GenderEnumTest extends TestCase
{
    /**
     * @see GenderEnum
     */
    public function testPositive()
    {
        $enum = new GenderEnum(GenderEnum::MAN);
        $this->assertEquals(GenderEnum::MAN, $enum->getValue());
        $this->assertEquals((string) GenderEnum::MAN, $enum);
    }

    /**
     * @see GenderEnum
     */
    public function testNegative()
    {
        $this->expectException(\UnexpectedValueException::class);
        new GenderEnum(\DateTime::class);
    }
}
