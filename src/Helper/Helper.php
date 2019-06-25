<?php

namespace PhpSolution\StdLib\Helper;

/**
 * Helper
 */
class Helper
{
    /**
     * @param string $field
     *
     * @return string
     */
    public static function getSetter($field): string
    {
        return 'set' . ucfirst($field);
    }

    /**
     * @param string $field
     *
     * @return string
     */
    public static function getGetter($field): string
    {
        return 'get' . ucfirst($field);
    }

    /**
     * @param string $string
     * @param bool   $capitalizeFirstChar
     *
     * @return string
     */
    public static function underscoreToCamelCase(string $string, bool $capitalizeFirstChar = false): string
    {
        $str = str_replace(' ', '', ucwords(str_replace('_', ' ', $string)));
        if (!$capitalizeFirstChar) {
            $str[0] = strtolower($str[0]);
        }

        return $str;
    }

    /**
     * @param string $string
     * @param bool   $capitalizedLettersIsSameWord
     * @param bool   $numbersIsSameWord
     *
     * @return string
     */
    public static function camelCaseToUnderscore(
        string $string,
        bool $capitalizedLettersIsSameWord = true,
        bool $numbersIsSameWord = false
    ): string {
        $pattern = sprintf(
            '/(?<!^)([A-Z]%s%s)/',
            $capitalizedLettersIsSameWord ? '+' : '',
            $numbersIsSameWord ? '' : '|[0-9]+'
        );

        return strtolower(preg_replace($pattern, '_$0', $string));
    }

    /**
     * @param mixed $value
     *
     * @return string
     */
    public static function getType($value): string
    {
        return is_object($value) ? get_class($value) : gettype($value);
    }

    /**
     * @deprecated
     * @see \PhpSolution\StdLib\Arrays\Arrays::extractByField
     *
     * @param array  $list
     * @param string $field
     *
     * @return array
     */
    public static function extractByField(array $list, string $field): array
    {
        $result = [];
        foreach ($list as $item) {
            $result[] = self::getItemValue($item, $field);
        }

        return $result;
    }

    /**
     * @deprecated
     * @see \PhpSolution\StdLib\Arrays\Arrays::indexByField
     *
     * @param array  $list
     * @param string $field
     *
     * @return array
     */
    public static function indexListByField(array $list, string $field): array
    {
        $result = [];
        foreach ($list as $item) {
            $result[self::getItemValue($item, $field)] = $item;
        }

        return $result;
    }

    /**
     * @param object|array $item
     * @param string       $field
     *
     * @return mixed
     */
    public static function getItemValue($item, string $field)
    {
        return is_object($item) ? $item->{$field}() : $item[$field];
    }

    /**
     * @param array $list
     * @param int   $page
     * @param int   $limit
     *
     * @return array
     */
    public static function paginateList(array $list, int $page, int $limit): array
    {
        $result = [];
        $i = 0;
        $offset = ($page - 1) * $limit;
        foreach ($list as $item) {
            if ($i++ < $offset) {
                continue;
            }
            $result[] = $item;
            if ($i >= $offset + $limit) {
                break;
            }
        }

        return $result;
    }
}
