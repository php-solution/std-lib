<?php

declare(strict_types=1);

namespace PhpSolution\StdLib\Arrays;

interface ArrayableInterface
{
    public function toArray(bool $withNull = true): array;
}
