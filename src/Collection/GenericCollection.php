<?php
namespace PhpSolution\StdLib\Collection;

/**
 * Class GenericCollection
 */
class GenericCollection extends AbstractGenericCollection
{
    /**
     * @var string
     */
    private $type;

    /**
     * @param string $type
     * @param array  $values
     */
    public function __construct($type, array $values = [])
    {
        $this->type = $type;
        parent::__construct($values);
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }
}