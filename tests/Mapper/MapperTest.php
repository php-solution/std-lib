<?php

namespace Tests\Mapper;

use PhpSolution\StdLib\Mapper\ObjectMapper;
use PHPUnit\Framework\TestCase;

/**
 * @see ObjectMapper
 */
class MapperTest extends TestCase
{
    /**
     * @see ObjectMapper
     */
    public function testArray()
    {
        $data = [
            'subObject1' => ['a' => 'aa', 'b' => 'bb'],
            'subObject2' => ['a' => 'aaa', 'b' => 'bbb'],
            'generic1' => [new \DateTime()],
            'generic2' => [['from' => new \DateTime('-1 day'), 'to' => new \DateTime()]],
            'array1' => [1, 2, 3],
            'array2' => [4, 5, 6],
            'scalar1' => 8,
            'scalar2' => true,
        ];

        $object = new MappedObject();
        $object = (new ObjectMapper($object))->map($data);

        $this->assertEquals($data['subObject1']['a'], $object->subObject1->a);
        $this->assertEquals($data['subObject1']['b'], $object->subObject1->b);
        $this->assertEquals($data['subObject2']['a'], $object->getSubObject2()->a);
        $this->assertEquals($data['subObject2']['b'], $object->getSubObject2()->b);
        $this->assertEquals($data['generic1'][0], $object->generic1[0]);
        $this->assertEquals($data['generic2'][0]['from'], $object->getGeneric2()[0]->getFrom());
        $this->assertEquals($data['generic2'][0]['to'], $object->getGeneric2()[0]->getTo());
        $this->assertEquals($data['array1'], $object->array1);
        $this->assertEquals($data['array2'], $object->getArray2());
        $this->assertEquals($data['scalar1'], $object->scalar1);
        $this->assertEquals($data['scalar2'], $object->isScalar2());
    }

    /**
     * @see ObjectMapper
     */
    public function testObject()
    {
        $data = new MappedData();
        $object = new MappedObject();
        $object = (new ObjectMapper($object))->map($data);

        $this->assertEquals($data->array2, $object->getArray2());
        $this->assertEquals($data->getScalar1(), $object->scalar1);
        $this->assertEquals($data->isScalar2(), $object->isScalar2());
    }
}
