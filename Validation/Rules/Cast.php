<?php
namespace ImmediateSolutions\Support\Validation\Rules;
use ImmediateSolutions\Support\Validation\Error;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
abstract class Cast extends AbstractRule
{
    /**
     * @var bool
     */
    private $soft;

    public function __construct($soft = false)
    {
        $this->soft = $soft;

        $this->setIdentifier('cast');
        $this->setMessage('The value must be '.$this->getType().'.');
    }

    /**
     * @param mixed $value
     * @return Error|null
     */
    public function check($value)
    {
        $valid = $this->soft ? $this->softCheck($value) : $this->hardCheck($value);

        if (!$valid){
            return $this->getError();
        }

        return null;
    }

    /**
     * @return string
     */
    protected abstract function getType();

    /**
     * @param $value
     * @return bool
     */
    protected abstract function softCheck($value);


    /**
     * @param $value
     * @return bool
     */
    protected abstract function hardCheck($value);
}