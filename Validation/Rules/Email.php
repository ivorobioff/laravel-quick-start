<?php
namespace ImmediateSolutions\Support\Validation\Rules;

use ImmediateSolutions\Support\Validation\Error;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Email extends AbstractRule
{
    public function __construct()
    {
        $this->setIdentifier('format');
        $this->setMessage('The email address has wrong format.');
    }

    /**
     * @param string $email
     * @return Error|null
     */
    public function check($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false){
            return $this->getError();
        }

        return null;
    }
}