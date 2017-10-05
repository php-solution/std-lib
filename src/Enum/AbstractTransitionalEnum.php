<?php

namespace PhpSolution\StdLib\Enum;

/**
 * AbstractTransitionalEnum
 */
abstract class AbstractTransitionalEnum extends AbstractEnum
{
    /**
     * @return array
     */
    abstract public function getTransitionRules(): array;

    /**
     * @param AbstractEnum|null $enum
     *
     * @return array
     */
    private function getAllowedTransitions(AbstractEnum $enum = null): array
    {
        $rules = $this->getTransitionRules();

        return  null === $enum ? $rules['create'] : $rules['transitions'][$enum->getValue()];
    }

    /**
     * @param AbstractEnum|null $enum
     *
     * @return bool
     */
    public function canReplace(AbstractEnum $enum = null): bool
    {
        return in_array($this->getValue(), $this->getAllowedTransitions($enum));
    }

    /**
     * @param AbstractEnum|null $enum
     *
     * @return bool
     */
    public function canBecome(AbstractEnum $enum = null): bool
    {
        return in_array(null === $enum ? null : $enum->getValue(), $this->getAllowedTransitions($this));
    }
}