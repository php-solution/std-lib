<?php

namespace Tests\Mapper;

use PhpSolution\StdLib\Time\Time;
use PHPUnit\Framework\TestCase;

/**
 * TimeTest
 */
class TimeTest extends TestCase
{
    /**
     * @see Time
     *
     * @param string $str
     * @param string $expectedResult
     *
     * @dataProvider correctDataProvider
     */
    public function testCorrect(string $str, string $expectedResult): void
    {
        $this->assertEquals($expectedResult, (string) Time::strToTime($str));
    }

    /**
     * @return array
     */
    public function correctDataProvider(): array
    {
        return [
            ['00:00', '00:00:00'],
            ['09:03', '09:03:00'],
            ['09:30:01', '09:30:01'],
            ['23:59:59', '23:59:59']
        ];
    }

    /**
     * @see Time
     *
     * @param string $str
     * @param string $exceptionMessage
     *
     * @dataProvider exceptionDataProvider
     */
    public function testExceptions(string $str, string $exceptionMessage): void
    {
        try {
            Time::strToTime($str);
        } catch (\RangeException $ex) {
            $this->assertEquals($exceptionMessage, $ex->getMessage());
        }
    }

    /**
     * @return array
     */
    public function exceptionDataProvider(): array
    {
        return [
            ['123456', Time::class . ': impossible parse "123456"'],
            ['-10:10', Time::class . ': impossible parse "-10:10"'],
            ['24:60:60', Time::class . ': impossible value "24" for hours'],
            ['23:60:60', Time::class . ': impossible value "60" for minutes'],
            ['23:59:60', Time::class . ': impossible value "60" for seconds'],
        ];
    }

    /**
     * @see Time
     *
     * @param int    $time
     * @param string $exceptionMessage
     *
     * @dataProvider wrongConstructorDataProvider
     */
    public function testWrongConstructor(int $time, string $exceptionMessage): void
    {
        try {
            new Time($time);
        } catch (\RangeException $ex) {
            $this->assertEquals($exceptionMessage, $ex->getMessage());
        }
    }

    /**
     * @return array
     */
    public function wrongConstructorDataProvider(): array
    {
        return [
            [-1, Time::class . ': incorrect value "-1"'],
            [86400, Time::class . ': incorrect value "86400"'],
        ];
    }
}