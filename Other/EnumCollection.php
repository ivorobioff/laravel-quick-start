<?php
namespace ImmediateSolutions\Support\Other;

use ArrayAccess;
use Countable;
use IteratorAggregate;
use ArrayIterator;
use RuntimeException;

/**
 * @author Sergei Melnikov <me@rnr.name>
 */
abstract class EnumCollection implements ArrayAccess, Countable, IteratorAggregate
{
    /**
     * @var array|Enum[]
     */
    private $data = [];

    /**
     * @param Enum[] $data
     */
    public function __construct($data = [])
    {
        foreach ($data as $item) {
            $this->push($item);
        }
    }

    /**
     * @return string
     */
    abstract public function getEnumClass();

    /**
     * @param array $data
     * @return static
     */
    public static function make(array $data)
    {
        $collection = new static();
        $class = $collection->getEnumClass();

        foreach ($data as $item) {
            $collection->push(new $class($item));
        }

        return $collection;
    }

    /**
     * @param Enum $item
     */
    public function push(Enum $item)
    {
        $this->verifyEnum($item);
        $this->data[] = $item;
    }

    /**
     * @return Enum
     */
    public function pop()
    {
        return array_pop($this->data);
    }

    /**
     * @param Enum $item
     * @return bool
     */
    public function has(Enum $item)
    {
        $this->verifyEnum($item);

        return in_array($item->value(), $this->toArray());
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return array_map(function (Enum $item) {
            return $item->value();
        }, $this->data);
    }

    /**
     * @return ArrayIterator
     */
    public function getIterator()
    {
        return new ArrayIterator($this->data);
    }

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->data);
    }

    /**
     * @param mixed $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->data[$offset];
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        $this->verifyEnum($value);

        $this->data[$offset] = $value;
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        unset($this->data[$offset]);
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->data);
    }

    /**
     * @param Enum $enum
     */
    private function verifyEnum(Enum $enum)
    {
        $valueClass = get_class($enum);
        $enumClass = $this->getEnumClass();

        if (!$enum instanceof $enumClass || !call_user_func([$enumClass, 'has'], $enum->value())) {
            throw new RuntimeException('The expected enum is "'.$enumClass.'" but "'.$valueClass.'" is given.');
        }
    }
}