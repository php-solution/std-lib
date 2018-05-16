<?php

namespace PhpSolution\StdLib\Arrays;

/**
 * Arrays
 */
class Arrays
{
    /**
     * @param iterable $list
     * @param string   $field
     *
     * @return array
     */
    public static function indexByField(iterable $list, string $field): array
    {
        $result = [];
        foreach ($list as $item) {
            $result[$item[$field]] = $item;
        }

        return $result;
    }
}
