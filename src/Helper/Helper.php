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
     * @param array  $list
     * @param string $field
     *
     * @return array
     */
    public static function extractByField(array $list, $field): array
    {
        $result = [];
        foreach ($list as $row) {
            $result[] = is_object($row) ? $row->{$field}() : $row[$field];
        }

        return $result;
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
}