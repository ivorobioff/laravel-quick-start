<?php
namespace ImmediateSolutions\Support\Validation\Rules;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class StringCast extends Cast
{
    public function __construct()
    {
        parent::__construct(false);
    }

    /**
     * @return string
     */
    protected function getType()
    {
        return 'string';
    }

    /**
     * @param $value
     * @return bool
     */
    protected function softCheck($value)
    {
        return $this->hardCheck($value);
    }

    /**
     * @param $value
     * @return bool
     */
    protected function hardCheck($value)
    {
        return is_string($value);
    }
}