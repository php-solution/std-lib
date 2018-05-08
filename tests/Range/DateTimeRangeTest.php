<?php

namespace Tests\Range;

use PhpSolution\StdLib\Range\DateTimeRange;
use PHPUnit\Framework\TestCase;

class DateTimeRangeTest extends TestCase
{
    /**
     * @throws \ReflectionException
     */
    public function testSetViaReflection(): void
    {
        $dateTimeRange = new DateTimeRange();
        $reflectionClass = new \ReflectionClass($dateTimeRange);
        $formProperty = $reflectionClass->getProperty('from');
        $formProperty->setAccessible(true);
        $formProperty->setValue($dateTimeRange, '2018-01-01T00:00:00+00:00');
        $toProperty = $reflectionClass->getProperty('to');
        $toProperty->setAccessible(true);
        $toProperty->setValue($dateTimeRange, '2018-02-01T00:00:00+00:00');

        $this->assertInstanceOf(\DateTime::class, $dateTimeRange->getFrom());
        $this->assertInstanceOf(\DateTime::class, $dateTimeRange->getTo());
        $this->assertEquals(
            '2018-01-01T00:00:00+00:00',
            $dateTimeRange->getFrom()->format(\DateTime::W3C)
        );
        $this->assertEquals(
            '2018-02-01T00:00:00+00:00',
            $dateTimeRange->getTo()->format(\DateTime::W3C)
        );
    }
}
