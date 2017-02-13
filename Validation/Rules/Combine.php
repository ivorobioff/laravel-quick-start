<?php
namespace ImmediateSolutions\Support\Validation\Rules;

use ImmediateSolutions\Support\Validation\Error;
use ImmediateSolutions\Support\Validation\Value;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Combine extends AbstractRule
{
    /**
     * @var AbstractRule[]
     */
    private $rules;

    /**
     * @param AbstractRule[] $rules
     */
    public function __construct(array $rules)
    {
        $this->rules = $rules;

        $this->setIdentifier('mixed');
        $this->setMessage('The provided value has not been accepted.');
    }

    /**
     * @param mixed|Value $value
     * @return Error|null
     */
    public function check($value)
    {
        foreach($this->rules as $rule){
            $error = $rule->check($value);

            if (!$error){
                return null;
            }
        }

        return $this->getError();
    }
}