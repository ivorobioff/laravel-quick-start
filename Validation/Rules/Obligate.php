<?php
namespace ImmediateSolutions\Support\Validation\Rules;

use ImmediateSolutions\Support\Validation\Error;
use ImmediateSolutions\Support\Validation\Value;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Obligate extends AbstractRule
{
    /**
     * @param string $message
     */
    public function __construct($message = 'The field is required.')
    {
        $this->setIdentifier('required');
        $this->setMessage($message);
    }

    /**
     * @param mixed $value
     * @return Error|null
     */
    public function check($value)
    {
        if (($value instanceof Value && $value->isNull()) || $value === null){
            return $this->getError();
        }

        return null;
    }

    /**
     * @return bool
     */
    public function isNullable()
    {
        return true;
    }
}