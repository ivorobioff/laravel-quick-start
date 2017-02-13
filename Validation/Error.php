<?php
namespace ImmediateSolutions\Support\Validation;

use RuntimeException;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Error
{
    /**
     * @var Error[]
     */
    private $extra;

    /**
     * @var string
     */
    private $identifier;

    /**
     * @var string
     */
    private $message;

    /**
     * @param string $identifier
     * @param string $message
     */
    public function __construct($identifier = null, $message = null)
    {
        if ($identifier !== null){
            $this->setIdentifier($identifier);
        }

        if ($message !== null){
            $this->setMessage($message);
        }
    }

    /**
     * @param string $identifier
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;
    }

    /**
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @param string $name
     * @param Error $error
     */
    public function addExtra($name, Error $error)
    {
        if (isset($this->extra[$name])){
            throw new RuntimeException('The child with the "'.$name.'" name is already added.');
        }

        $this->extra[$name] = $error;
    }

    /**
     * @param string $name
     * @return Error[]
     */
    public function getExtra($name = null)
    {
        if ($name){
            return $this->extra[$name];
        }

        return $this->extra;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function hasExtra($name = null)
    {
        if ($name){
            return isset($this->extra[$name]);
        }

        return count($this->extra) > 0;
    }
}