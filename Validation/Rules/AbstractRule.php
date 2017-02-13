<?php
namespace ImmediateSolutions\Support\Validation\Rules;

use ImmediateSolutions\Support\Validation\Error;
use ImmediateSolutions\Support\Validation\RuleInterface;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
abstract class AbstractRule implements RuleInterface
{
    /**
     * @var string
     */
    private $identifier;

    /**
     * @var Error
     */
    private $error;

    /**
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * @param string $identifier
     * @return $this
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;
        $this->getError()->setIdentifier($identifier);
        return $this;
    }

    /**
     * @param string $message
     * @return $this
     */
    public function setMessage($message)
    {
        $this->getError()->setMessage($message);
        return $this;
    }

    /**
     * @return Error
     */
    protected function getError()
    {
        if ($this->error === null){
            $this->error = new Error();
        }

        return $this->error;
    }

    /**
     * @return bool
     */
    public function isNullable()
    {
        return false;
    }
}