<?php
namespace ImmediateSolutions\Support\Validation;

use IteratorAggregate;
use ArrayIterator;
use Countable;
use ArrayAccess;
use RuntimeException;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class ErrorsThrowableCollection extends PresentableException implements IteratorAggregate, Countable, ArrayAccess
{
    /**
     * @var Error[]
     */
    private $errors = [];

    public function __construct()
    {
        parent::__construct('The data has not passed the validation.');
    }

    /**
     * @return Error[]|ArrayIterator
     */
    public function getIterator()
    {
        return new ArrayIterator($this->errors);
    }

    /**
     * @param string $property
     * @return bool
     */
    public function offsetExists($property)
    {
        return isset($this->errors[$property]);
    }

    /**
     * @param string $property
     * @return Error
     */
    public function offsetGet($property)
    {
        return $this->errors[$property];
    }

    /**
     * @param string $property
     * @param Error $error
     */
    public function offsetSet($property, $error)
    {
        if (!$error instanceof Error){
            throw new RuntimeException('The error must be instance of the "Error" class.');
        }

        $this->errors[$property] = $error;
    }

    /**
     * @param string $property
     */
    public function offsetUnset($property)
    {
        unset($this->errors[$property]);
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->errors);
    }

    /**
     * @param string $field
     * @param Error $error
     * @throws static
     */
    public static function throwError($field, Error $error)
    {
        $errors = new static();

        $errors[$field] = $error;

        throw $errors;
    }
}