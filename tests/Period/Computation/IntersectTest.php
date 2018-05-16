<?php

namespace Tests\Period\Computation;

use PhpSolution\StdLib\Period\Computation;
use PhpSolution\StdLib\Range\DateTimeRange;

/**
 * @see Computation::isIntersect()
 */
class IntersectTest extends AbstractComputationTest
{
    /**
     * @var DateTimeRange;
     */
    private $april;

    /**
     * @var DateTimeRange
     */
    private $startInfinity;

    /**
     * @var DateTimeRange
     */
    private $endInfinity;

    /**
     * @see Computation::isIntersect()
     *
     * @dataProvider intersectDataProvider
     *
     * @param DateTimeRange $a
     * @param DateTimeRange $b
     * @param bool       $expectedResult
     */
    public function testIntersect(DateTimeRange $a, DateTimeRange $b, bool $expectedResult)
    {
        $this->assertEquals($expectedResult, Computation::isIntersect($a, $b));
    }

    /**
     * @return array
     */
    public function intersectDataProvider()
    {
        $this->april = $this->getAprilPeriod();
        $this->startInfinity = (new DateTimeRange())->setFrom(null)->setTo((new \DateTime())->setTimestamp(rand(0, time())));
        $this->endInfinity = (new DateTimeRange())->setFrom((new \DateTime())->setTimestamp(rand(0, time())))->setTo(null);

        $tests = array_merge(
            $this->getBothInfinityTests(),
            $this->getSingleInfinityTest(false),
            $this->getSingleInfinityTest(true),
            [
                [
                    'a' => $this->april,
                    'b' => (new DateTimeRange())->setFrom(new \DateTime('2000-03-07'))->setTo(new \DateTime('2000-04-09')),
                    'expectedResult' => true
                ],
                [
                    'a' => $this->april,
                    'b' => (new DateTimeRange())->setFrom(new \DateTime('2000-03-07'))->setTo(new \DateTime('2000-03-09')),
                    'expectedResult' => false
                ],
                [
                    'a' => (new DateTimeRange())->setFrom(new \DateTime('2000-03-07'))->setTo(new \DateTime('2000-04-09')),
                    'b' => $this->april,
                    'expectedResult' => true
                ],
                [
                    'a' => (new DateTimeRange())->setFrom(new \DateTime('2000-03-07'))->setTo(new \DateTime('2000-03-09')),
                    'b' => $this->april,
                    'expectedResult' => false
                ]
            ]
        );

        return $tests;
    }

    /**
     * @return array
     */
    private function getBothInfinityTests()
    {
        return [
            [
                'a' => new DateTimeRange(),
                'b' => new DateTimeRange(),
                'expectedResult' => true
            ],
            [
                'a' => new DateTimeRange(),
                'b' => $this->april,
                'expectedResult' => true
            ],
            [
                'a' => $this->april,
                'b' => new DateTimeRange(),
                'expectedResult' => true
            ],
            [
                'a' => $this->startInfinity,
                'b' => $this->startInfinity,
                'expectedResult' => true
            ],
            [
                'a' => $this->endInfinity,
                'b' => $this->endInfinity,
                'expectedResult' => true
            ]
        ];
    }

    /**
     * @param bool $swap
     *
     * @return array
     */
    private function getSingleInfinityTest(bool $swap)
    {
        $tests = [
            [
                'a' => (clone $this->startInfinity)->setTo(new \DateTime('2000-04-01')),
                'b' => (clone $this->endInfinity)->setFrom(new \DateTime('2000-03-01')),
                'expectedResult' => true
            ],
            [
                'a' => (clone $this->startInfinity)->setTo(new \DateTime('2000-04-01')),
                'b' => (clone $this->endInfinity)->setFrom(new \DateTime('2000-04-02')),
                'expectedResult' => false
            ],
            [
                'a' => (clone $this->startInfinity)->setTo(new \DateTime('2000-04-05')),
                'b' => $this->april,
                'expectedResult' => true
            ],
            [
                'a' => (clone $this->startInfinity)->setTo(new \DateTime('2000-03-31')),
                'b' => $this->april,
                'expectedResult' => false
            ],
        ];
        if ($swap) {
            $swappedTests = [];
            foreach ($tests as $test) {
                $swappedTests[] = ['a' => $test['b'], 'b' => $test['a'], 'expectedResult' => $test['expectedResult']];
            }
            return $swappedTests;
        } else {
            return $tests;
        }
    }
}
