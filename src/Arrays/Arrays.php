<?php

namespace PhpSolution\StdLib\Arrays;

use PhpSolution\StdLib\Helper\Helper;

/**
 * Arrays
 */
class Arrays
{
    /**
     * Needs for collection of objects. For arrays can be used array_column()
     *
     * @param iterable $list
     * @param string   $field
     *
     * @return array
     */
    public static function extractByField(iterable $list, string $field): array
    {
        $result = [];
        foreach ($list as $item) {
            $result[] = Helper::getItemValue($item, $field);
        }

        return $result;
    }

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
