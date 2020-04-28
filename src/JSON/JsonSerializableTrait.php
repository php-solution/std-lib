<?php

declare(strict_types=1);

namespace PhpSolution\StdLib\JSON;

trait JsonSerializableTrait
{
    public function jsonSerialize(): array
    {
        $result = [];
        foreach ($this as $key => $value) {
            $result[$key] = $value instanceof \DateTimeInterface
                ? $value->format(\DateTime::W3C)
                : $value;
        }
        return $result;
    }
}