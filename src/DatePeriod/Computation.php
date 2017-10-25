<?php

namespace PhpSolution\StdLib\DatePeriod;

use PhpSolution\StdLib\Consequence\Change;
use PhpSolution\StdLib\Consequence\ConsequenceCollection;
use PhpSolution\StdLib\Consequence\Creation;
use PhpSolution\StdLib\Consequence\Destruction;

/**
 * This class is necessary for carrying out operations with date periods
 */
class Computation
{
    /**
     * Checks, does period $a and $b intersect
     *
     * @param DatePeriodInterface $a
     * @param DatePeriodInterface $b
     *
     * @return bool
     */
    static public function isIntersect(DatePeriodInterface $a, DatePeriodInterface $b): bool
    {
        $aStart = $a->getDateStart();
        $aEnd = $a->getDateEnd();
        $bStart = $b->getDateStart();
        $bEnd = $b->getDateEnd();

        return $aStart > $bStart
            ? $bEnd >= $aStart || $bEnd === null
            : $aEnd >= $bStart || $aEnd === null;
    }

    /**
     * Subtracts $subtrahend from $minuend. And return list of consequence
     *
     * @param DatePeriodInterface $minuend
     * @param DatePeriodInterface $subtrahend
     *
     * @return ConsequenceCollection
     */
    static public function subtraction(DatePeriodInterface $minuend, DatePeriodInterface $subtrahend): ConsequenceCollection
    {
        if (!self::isIntersect($minuend, $subtrahend)) {
            return new ConsequenceCollection();
        }

        $subtrahend = self::expand(clone $subtrahend);

        $isSubtrahendStartBeforeMinuend = $subtrahend->getDateStart() === null ||
            ($minuend->getDateStart() !== null && ($minuend->getDateStart() > $subtrahend->getDateStart()));

        $isSubtrahendEndAfterMinuend = $subtrahend->getDateEnd() === null ||
            ($minuend->getDateEnd() !== null && $minuend->getDateEnd() < $subtrahend->getDateEnd());

        switch (true) {
            case $isSubtrahendStartBeforeMinuend && $isSubtrahendEndAfterMinuend:

                return new ConsequenceCollection([new Destruction($minuend)]);
            case $isSubtrahendStartBeforeMinuend && !$isSubtrahendEndAfterMinuend:
                $minuend->setDateStart($subtrahend->getDateEnd());

                return new ConsequenceCollection([new Change($minuend)]);
            case !$isSubtrahendStartBeforeMinuend && $isSubtrahendEndAfterMinuend:
                $minuend->setDateEnd($subtrahend->getDateStart());

                return new ConsequenceCollection([new Change($minuend)]);
            case !$isSubtrahendStartBeforeMinuend && !$isSubtrahendEndAfterMinuend:
                $newPeriod = (clone $minuend)->setDateStart($subtrahend->getDateEnd());
                $minuend->setDateEnd($subtrahend->getDateStart());

                return new ConsequenceCollection([new Creation($newPeriod), new Change($minuend)]);
            default:
                throw new \LogicException();
        }
    }

    /**
     * Merge period $a with period $b if possible
     *
     * @param DatePeriodInterface $a
     * @param DatePeriodInterface $b
     *
     * @return ConsequenceCollection
     */
    static public function merge(DatePeriodInterface $a, DatePeriodInterface $b)
    {
        $collection = new ConsequenceCollection();
        if (!self::isIntersect($a, self::expand(clone $b))) {
            return $collection;
        }

        $changed = false;
        if ($a->getDateStart() > $b->getDateStart()) {
            $a->setDateStart($b->getDateStart());
            $changed = true;
        }
        if ($a->getDateEnd() !== null && ($b->getDateEnd() === null || $a->getDateEnd() < $b->getDateEnd())) {
            $a->setDateEnd($b->getDateEnd());
            $changed = true;
        }

        $collection[] = new Destruction($b);
        if ($changed) {
            $collection[] = new Change($a);
        }

        return $collection;
    }

    /**
     * Truncate $minuend period
     *
     * @param DatePeriodInterface $minuend
     * @param DatePeriodInterface $to
     *
     * @return ConsequenceCollection
     */
    static public function truncate(DatePeriodInterface $minuend, DatePeriodInterface $to)
    {
        $changed = false;
        if ($to->getDateStart() !== null && $to->getDateStart() > $minuend->getDateStart()) {
            $changed = true;
            $minuend->setDateStart(clone $to->getDateStart());
        }
        if ($to->getDateEnd() !== null && ($to->getDateEnd() < $minuend->getDateEnd() || $minuend->getDateEnd() === null)) {
            $changed = true;
            $minuend->setDateEnd(clone $to->getDateEnd());
        }

        $collection = new ConsequenceCollection();
        if ($changed) {
            $collection[] = new Change($minuend);
        }

        return $collection;
    }

    /**
     * Expands the incoming period
     *
     * @param DatePeriodInterface $object
     * @param string              $before
     * @param string              $after
     *
     * @return DatePeriodInterface
     */
    static public function expand(DatePeriodInterface $object, string $before = '-1 second', string $after = '+1 second'): DatePeriodInterface
    {
        if ($object->getDateStart() !== null) {
            $object->getDateStart()->modify($before);
        }

        if ($object->getDateEnd() !== null) {
            $object->getDateEnd()->modify($after);
        }

        return $object;
    }

    /**
     * @param DatePeriodInterface[] $list
     */
    static public function sort(array &$list)
    {
        usort($list, function (DatePeriodInterface $a, DatePeriodInterface $b) {
            if ($a->getDateStart() === $b->getDateStart()) {
                if ($a->getDateEnd() === $b->getDateEnd()) {
                    return 0;
                }

                return $a->getDateEnd() > $b->getDateEnd();
            }

            return $a->getDateStart() > $b->getDateStart();
        });
    }
}