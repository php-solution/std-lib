<?php
namespace Tests\DatePeriod\Computation;

use PhpSolution\StdLib\DatePeriod\Computation;
use PhpSolution\StdLib\DatePeriod\DatePeriod;

/**
 * @see \PhpSolution\StdLib\DatePeriod\Computation::isIntersect()
 */
class IntersectTest extends AbstractComputationTest
{
    /**
     * @var DatePeriod;
     */
    private $april;
    /**
     * @var DatePeriod
     */
    private $startInfinity;
    /**
     * @var DatePeriod
     */
    private $endInfinity;

    /**
     * @see \PhpSolution\StdLib\DatePeriod\Computation::isIntersect()
     *
     * @param DatePeriod $a
     * @param DatePeriod $b
     * @param bool       $expectedResult
     *
     * @dataProvider intersectDataProvider
     */
    public function testIntersect(DatePeriod $a, DatePeriod $b, bool $expectedResult)
    {
        $this->assertEquals($expectedResult, Computation::isIntersect($a, $b));
    }

    /**
     * @return array
     */
    public function intersectDataProvider()
    {
        $this->april = $this->getAprilPeriod();
        $this->startInfinity = (new DatePeriod())->setDateStart(null)->setDateEnd((new \DateTime())->setTimestamp(rand(0, time())));
        $this->endInfinity = (new DatePeriod())->setDateStart((new \DateTime())->setTimestamp(rand(0, time())))->setDateEnd(null);

        $tests = array_merge(
            $this->getBothInfinityTests(),
            $this->getSingleInfinityTest(false),
            $this->getSingleInfinityTest(true),
            [
                [
                    'a' => $this->april,
                    'b' => (new DatePeriod())->setDateStart(new \DateTime('2000-03-07'))->setDateEnd(new \DateTime('2000-04-09')),
                    'expectedResult' => true
                ],
                [
                    'a' => $this->april,
                    'b' => (new DatePeriod())->setDateStart(new \DateTime('2000-03-07'))->setDateEnd(new \DateTime('2000-03-09')),
                    'expectedResult' => false
                ],
                [
                    'a' => (new DatePeriod())->setDateStart(new \DateTime('2000-03-07'))->setDateEnd(new \DateTime('2000-04-09')),
                    'b' => $this->april,
                    'expectedResult' => true
                ],
                [
                    'a' => (new DatePeriod())->setDateStart(new \DateTime('2000-03-07'))->setDateEnd(new \DateTime('2000-03-09')),
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
                'a' => new DatePeriod(),
                'b' => new DatePeriod(),
                'expectedResult' => true
            ],
            [
                'a' => new DatePeriod(),
                'b' => $this->april,
                'expectedResult' => true
            ],
            [
                'a' => $this->april,
                'b' => new DatePeriod(),
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
                'a' => (clone $this->startInfinity)->setDateEnd(new \DateTime('2000-04-01')),
                'b' => (clone $this->endInfinity)->setDateStart(new \DateTime('2000-03-01')),
                'expectedResult' => true
            ],
            [
                'a' => (clone $this->startInfinity)->setDateEnd(new \DateTime('2000-04-01')),
                'b' => (clone $this->endInfinity)->setDateStart(new \DateTime('2000-04-02')),
                'expectedResult' => false
            ],
            [
                'a' => (clone $this->startInfinity)->setDateEnd(new \DateTime('2000-04-05')),
                'b' => $this->april,
                'expectedResult' => true
            ],
            [
                'a' => (clone $this->startInfinity)->setDateEnd(new \DateTime('2000-03-31')),
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