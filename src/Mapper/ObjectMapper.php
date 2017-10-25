<?php

namespace PhpSolution\StdLib\Mapper;

use PhpSolution\StdLib\Collection\GenericCollection;
use PhpSolution\StdLib\Helper\Helper;

/**
 * ObjectMapper
 */
class ObjectMapper
{
    /**
     * @var object
     */
    private $object;
    /**
     * @var string[]
     */
    private $properties;
    /**
     * @var string[]
     */
    private $methods;

    /**
     * @param object $object
     */
    public function __construct($object)
    {
        if (!is_object($object)) {
            throw new \InvalidArgumentException('Object mapper can map only to object');
        }
        $this->object = $object;
        $this->properties = get_object_vars($object);
        $this->methods = get_class_methods($object);
    }

    /**
     * @param object|array $data
     *
     * @return object
     */
    public function map($data)
    {
        switch (true) {
            case is_array($data):
                foreach ($data as $field => $value) {
                    $this->mapField((string) $field, $value);
                }
                break;
            case is_object($data):
                $properties = get_object_vars($data);
                foreach ($properties as $property => $value) {
                    $this->mapField($property, $value);
                }

                $methods = get_class_methods($data);
                foreach ($methods as $method) {
                    if (preg_match('/^(get|is).+/', $method)) {
                        $field = preg_replace('/^(get|is)/', '', $method);
                        $field[0] = strtolower($field[0]);
                        $this->mapField($field, $data->{$method}());
                    }
                }
                break;
            default:
                throw new \InvalidArgumentException('Object mapper can map only array or object');
        }

        return $this->object;
    }

    /**
     * @param string $field
     * @param mixed  $value
     */
    private function mapField(string $field, $value): void
    {
        switch (true) {
            case $this->mapSubObject($field, $value):
                return;
            case $this->mapGenericCollection($field, $value):
                return;
        }

        if (in_array(Helper::getSetter($field), $this->methods)) {
            $this->object->{Helper::getSetter($field)}($value);
        } elseif (array_key_exists($field, $this->properties)) {
            $this->object->{$field} = $value;
        } elseif ($this->object instanceof \ArrayAccess) {
            $object[$field] = $value;
        }
    }

    /**
     * @param string $field
     * @param mixed  $value
     *
     * @return bool
     */
    private function mapGenericCollection(string $field, $value): bool
    {
        if ($this->object instanceof GenericCollection) {
            if (is_array($value)) {
                $className = $this->object->getType();
                $this->object[$field] = (new self(new $className))->map($value);
            } else {
                $this->object[$field] = $value;
            }

            return true;
        }

        return false;
    }

    /**
     * @param string       $field
     * @param array|object $value
     *
     * @return bool
     */
    private function mapSubObject(string $field, $value): bool
    {
        if (!(is_object($value) || is_array($value))) {
            return false;
        }

        if (in_array(Helper::getGetter($field), $this->methods)) {
            $subObject = $this->object->{Helper::getGetter($field)}();
        } elseif (array_key_exists($field, $this->properties)) {
            $subObject = $this->object->{$field};
        }

        if (isset($subObject) && is_object($subObject)) {
            (new self($subObject))->map($value);

            return true;
        }

        return false;
    }
}