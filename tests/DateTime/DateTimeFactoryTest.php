<?php

declare(strict_types=1);

namespace Tests\DateTime;

use PhpSolution\StdLib\DateTime\DateTimeFactory;
use PHPUnit\Framework\TestCase;

/**
 * @see DateTimeFactory
 */
class DateTimeFactoryTest extends TestCase
{

    /**
     * @dataProvider setNextTimeProvider
     *
     * @see DateTimeFactory::setNextTime()
     */
    public function testSetNextTime(
        string $type,
        int $time,
        \DateTime $dateTime,
        \DateTime $greaterThen,
        \DateTime $expectedValue
    ): void {
        self::assertEquals($expectedValue, (new DateTimeFactory())->setNextTime($type, $time, $dateTime, $greaterThen));
    }

    public function setNextTimeProvider(): array
    {
        $april_5_2021 = new \DateTime('April 5 2021 00:00:00');

        return [
            'Periodic same date' => [
                'type' => DateTimeFactory::TYPE_PERIOD,
                'time' => 3600,
                'dateTime' => clone $april_5_2021,
                'greaterThen' => clone $april_5_2021,
                'expectedValue' => (clone $april_5_2021)->setTime(1, 0, 0),
            ],
            'Periodic +1 second' => [
                'type' => DateTimeFactory::TYPE_PERIOD,
                'time' => 3600,
                'dateTime' => clone $april_5_2021,
                'greaterThen' => (clone $april_5_2021)->modify('+1 second'),
                'expectedValue' => (clone $april_5_2021)->setTime(1, 0, 0),
            ],
            'Periodic +2 hours' => [
                'type' => DateTimeFactory::TYPE_PERIOD,
                'time' => 3600,
                'dateTime' => clone $april_5_2021,
                'greaterThen' => (clone $april_5_2021)->modify('+2 hours'),
                'expectedValue' => (clone $april_5_2021)->setTime(3, 0, 0),
            ],
            'Periodic +23 hours 1 second' => [
                'type' => DateTimeFactory::TYPE_PERIOD,
                'time' => 3600,
                'dateTime' => clone $april_5_2021,
                'greaterThen' => (clone $april_5_2021)->modify('+23 hours 1 second'),
                'expectedValue' => (clone $april_5_2021)->modify('+1 day'),
            ],
            'Daily today' => [
                'type' => DateTimeFactory::TYPE_DAILY,
                'time' => 3600,
                'dateTime' => clone $april_5_2021,
                'greaterThen' => clone $april_5_2021,
                'expectedValue' => (clone $april_5_2021)->setTime(1, 0, 0),
            ],
            'Daily next day' => [
                'type' => DateTimeFactory::TYPE_DAILY,
                'time' => 3600,
                'dateTime' => $april_5_2021,
                'greaterThen' => (clone $april_5_2021)->modify('+5 hours'),
                'expectedValue' => (clone $april_5_2021)->modify('+1 day')->setTime(1, 0, 0),
            ],
        ];
    }
}