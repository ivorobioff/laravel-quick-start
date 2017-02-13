<?php
namespace ImmediateSolutions\Support\Validation\Rules;

use ImmediateSolutions\Support\Validation\Error;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Between extends AbstractRule
{
    /**
     * @var int|float
     */
    private $first;

    /**
     * @var int|float
     */
    private $last;

    public function __construct($first, $last)
    {
        $this->first = $first;
        $this->last = $last;

        $this->setIdentifier('between');
        $this->setMessage('The number must be between '.$first.' and '.$last.'.');
    }

    /**
     * @param mixed $value
     * @return Error|null
     */
    public function check($value)
    {
        if ($value >= $this->first && $value <= $this->last){
            return null;
        }

        return $this->getError();
    }
}