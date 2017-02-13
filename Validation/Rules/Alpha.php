<?php
namespace ImmediateSolutions\Support\Validation\Rules;

use ImmediateSolutions\Support\Validation\Error;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Alpha extends AbstractRule
{
    use WithSpacesTrait;

    public function __construct()
    {
        $this->setMessage('The field must contain letters only.');
        $this->setIdentifier('alpha');
    }

    /**
     * @param mixed $value
     * @return Error|null
     */
    public function check($value)
    {
        $error = (new Regex('/^['.$this->applySpaces('a-zA-Z').']+$/'))->check($value);

        if ($error){
            return $this->getError();
        }

        return null;
    }
}