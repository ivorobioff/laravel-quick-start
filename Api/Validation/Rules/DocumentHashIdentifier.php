<?php
namespace ImmediateSolutions\Support\Api\Validation\Rules;
use ImmediateSolutions\Support\Validation\Error;
use ImmediateSolutions\Support\Validation\Rules\AbstractRule;
use ImmediateSolutions\Support\Validation\Value;

/**
 *
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class DocumentHashIdentifier extends AbstractRule
{
    public function __construct()
    {
        $this->setIdentifier('cast');
        $this->setMessage('The document identifier must be hash consisting of id as integer and token as string.');
    }

    /**
     *
     * @param mixed|Value $value
     * @return Error|null
     */
    public function check($value)
    {
        if (! is_array($value)) {
            return $this->getError();
        }

        if (! isset($value['id']) || ! isset($value['token'])) {
            return $this->getError();
        }

        if (! is_int($value['id']) || ! is_string($value['token'])) {
            return $this->getError();
        }

        return null;
    }
}