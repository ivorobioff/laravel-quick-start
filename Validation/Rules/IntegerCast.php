<?php
namespace ImmediateSolutions\Support\Validation\Rules;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class IntegerCast extends Cast
{
    /**
     * @return string
     */
    protected function getType()
    {
        return 'integer';
    }

    /**
     * @param $value
     * @return bool
     */
    protected function softCheck($value)
    {
        return (bool) filter_var($value, FILTER_VALIDATE_INT);
    }

    /**
     * @param $value
     * @return bool
     */
    protected function hardCheck($value)
    {
        return is_int($value);
    }
}