<?php
namespace ImmediateSolutions\Support\Validation;

use IteratorAggregate;
use ArrayIterator;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Binder implements IteratorAggregate
{
    /**
     * @var array|callable[]
     */
    private $inflators = [];


    /**
     * @param string $name
     * @param callable|array $inflatorOrBundle
     * @param callable|null $inflator
     * @return Bundle
     */
    public function bind($name, $inflatorOrBundle, callable $inflator = null)
    {
        if (is_callable($inflatorOrBundle) && $inflator === null){
            $inflator = $inflatorOrBundle;
            $bundle = new Bundle($name, [$name]);
        } else{
            $bundle = new Bundle($name, $inflatorOrBundle);
        }

        $this->inflators[] = [$bundle, $inflator];

        return $bundle;
    }

    /**
     * @return callable[]
     */
    public function getIterator()
    {
        return new ArrayIterator($this->inflators);
    }
}