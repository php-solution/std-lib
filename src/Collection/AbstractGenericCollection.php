<?php
namespace PhpSolution\StdLib\Collection;

/**
 * Class AbstractGenericCollection
 */
abstract class AbstractGenericCollection extends \ArrayIterator
{
    /**
     * @return string
     */
    abstract protected function getType(): string;

    /**
     * @param mixed $value
     *
     * @return mixed
     * @throws \InvalidArgumentException
     */
    protected function checkType($value)
    {
        $type = $this->getType();
        if (!$value instanceof $type) {
            throw new \InvalidArgumentException(static::class . ' expects values of "' . $type . '" type');
        }

        return $value;
    }

    /**
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        foreach ($values as $value) {
            $this->append($value);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($index, $newval): void
    {
        parent::offsetSet($index, $this->checkType($newval));
    }

    /**
     * {@inheritdoc}
     */
    public function append($value): void
    {
        parent::append($this->checkType($value));
    }
}