<?php
namespace ImmediateSolutions\Support\Validation\Rules;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class FloatCast extends Cast
{
    /**
     * @return string
     */
    protected function getType()
    {
        return 'float';
    }

    /**
     * @param $value
     * @return bool
     */
    protected function softCheck($value)
    {
        return (bool) filter_var($value, FILTER_VALIDATE_FLOAT);
    }

    /**
     * @param $value
     * @return bool
     */
    protected function hardCheck($value)
    {
        return is_float($value) || is_int($value);
    }
}