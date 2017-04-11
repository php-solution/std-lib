<?php
namespace Tests\Enum;

use PhpSolution\StdLib\Enum\GenderEnum;
use PHPUnit\Framework\TestCase;

/**
 * @see \PhpSolution\StdLib\Enum\GenderEnum
 */
class GenderEnumTest extends TestCase
{
    /**
     * @see \PhpSolution\StdLib\Enum\GenderEnum
     */
    public function testPositive()
    {
        $enum = new GenderEnum(GenderEnum::MAN);
        $this->assertEquals(GenderEnum::MAN, $enum->getValue());
        $this->assertEquals((string) GenderEnum::MAN, $enum);
    }

    /**
     * @see \PhpSolution\StdLib\Enum\GenderEnum
     */
    public function testNegative()
    {
        $this->expectException(\UnexpectedValueException::class);
        new GenderEnum(\DateTime::class);
    }
}