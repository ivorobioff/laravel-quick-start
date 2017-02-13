<?php
namespace ImmediateSolutions\Support\Validation\Rules;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class BooleanCast extends Cast
{
    /**
     * @return string
     */
    protected function getType()
    {
        return 'boolean';
    }

    /**
     * @param $value
     * @return bool
     */
    protected function softCheck($value)
    {
        $allowed = [true, false, 'true', 'false'];
        return in_array($value, $allowed, true);
    }

    /**
     * @param $value
     * @return bool
     */
    protected function hardCheck($value)
    {
        return is_bool($value);
    }
}