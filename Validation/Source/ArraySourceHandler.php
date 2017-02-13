<?php
namespace ImmediateSolutions\Support\Validation\Source;

use ImmediateSolutions\Support\Validation\SourceHandlerInterface;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class ArraySourceHandler implements SourceHandlerInterface
{
    /**
     * @var array
     */
    private $data;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function getSource()
    {
        return $this->data;
    }

    /**
     * @param string $property
     * @return mixed
     */
    public function getValue($property)
    {
        return array_get($this->data, $property);
    }

    /**
     * @param string $property
     * @return bool
     */
    public function hasProperty($property)
    {
        return array_has($this->data, $property);
    }
}