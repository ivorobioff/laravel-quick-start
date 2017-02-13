<?php
namespace ImmediateSolutions\Support\Validation\Rules;

use ImmediateSolutions\Support\Validation\Error;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Numeric extends AbstractRule
{
    public function __construct()
    {
        $this->setMessage('The field must contain digits only.');
        $this->setIdentifier('numeric');
    }

    /**
     * @param mixed $value
     * @return Error|null
     */
    public function check($value)
    {
        $error = (new Regex('/^[0-9]+$/'))->check($value);

        if ($error){
            return $this->getError();
        }

        return null;
    }
}