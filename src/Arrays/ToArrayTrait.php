<?php

declare(strict_types=1);

namespace PhpSolution\StdLib\Arrays;

trait ToArrayTrait
{
    public function toArray(bool $withNull = true): array
    {
        $result = [];
        foreach (get_object_vars($this) as $key => $value) {
            $result[$key] = $value;
        }
        foreach (get_class_methods($this) as $method) {
            if (strpos($method, 'is') === 0) {
                $result[lcfirst(substr($method, 2))] = $this->{$method}();
            } elseif (strpos($method, 'get') === 0) {
                $result[lcfirst(substr($method, 3))] = $this->{$method}();
            }
        }

        foreach ($result as $key => $value) {
            if ($value instanceof ArrayableInterface) {
                $result[$key] = $value->toArray($withNull);
            } elseif (is_iterable($value)) {
                foreach ($value as $i => $v) {
                    if ($v instanceof ArrayableInterface) {
                        $value[$i] = $v->toArray($withNull);
                    }
                }
                $result[$key] = $value;
            }
        }

        if (!$withNull) {
            $result = array_filter($result, function ($item) {
                return $item !== null;
            });
        }

        return $result;
    }
}
