<?php
namespace ImmediateSolutions\Support\Validation\Rules;

use ImmediateSolutions\Support\Validation\Error;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Regex extends AbstractRule
{
    private $pattern;

    /**
     * @param string $pattern
     */
    public function __construct($pattern)
    {
        $this->pattern = $pattern;

        $this->setIdentifier('format');
        $this->setMessage('The value has incorrect format.');
    }

    /**
     * @param mixed $value
     * @return Error|null
     */
    public function check($value)
    {
        if (preg_match($this->pattern, $value) > 0){
            return null;
        }

        return $this->getError();
    }
}