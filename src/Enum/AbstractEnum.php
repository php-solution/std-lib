<?php
namespace PhpSolution\StdLib\Enum;

/**
 * Class AbstractEnum
 */
abstract class AbstractEnum
{
    /**
     * @var mixed
     */
    protected $value;
    /**
     * @var bool
     */
    protected $strict = true;

    /**
     * @param mixed $value
     *
     * @throws \UnexpectedValueException if incompatible type is given.
     */
    public function __construct($value)
    {
        if (!$this->isValid($value)) {
            throw new \UnexpectedValueException("Value '{$value}' is not part of the enum " . get_called_class());
        }
        $this->value = $value;
    }

    /**
     * @return array
     */
    abstract protected function getAllowedValues();

    /**
     * @param mixed $value
     *
     * @return bool
     */
    protected function isValid($value)
    {
        return in_array($value, $this->getAllowedValues(), $this->strict);
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public static function getDescription(): string
    {
        $descriptions = [];
        foreach (static::getDescriptions() as $key => $value) {
            $descriptions[] = $key . ': ' . $value;
        }

        return 'Allowed values: ' . implode(', ', $descriptions);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->value;
    }
}
