<?php
namespace ImmediateSolutions\Support\Validation\Rules;

use DateTime;
use ImmediateSolutions\Support\Validation\Error;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
abstract class Compare extends AbstractRule
{
    /**
     * @var int|float|DateTime
     */
    private $numberOrDateTime;

    /**
     * @var bool
     */
    private $inclusive;

    /**
     * @param int|float|DateTime $numberOrDatetime
     * @param bool $inclusive
     */
    public function __construct($numberOrDatetime, $inclusive = true)
    {
        $this->numberOrDateTime = $numberOrDatetime;
        $this->inclusive = $inclusive;

        $this->setIdentifier($this->getDirection());

        $this->setMessage($this->prepareMessage($numberOrDatetime, $inclusive));
    }

    /**
     * @param int|float|DateTime $numberOrDatetime
     * @param bool|true $inclusive
     * @return string
     */
    private function prepareMessage($numberOrDatetime, $inclusive = true)
    {
        $inclusiveMessage = '';

        if ($inclusive){
            $inclusiveMessage = ' or equal';
        }

        $type = 'number';

        if ($numberOrDatetime instanceof DateTime){
            $numberOrDatetime = $numberOrDatetime->format('Y-m-d H:i:s');
            $type = 'datetime';
        }

        return 'The '.$type.' must be '.$this->getDirection().' than'.$inclusiveMessage.' "'.$numberOrDatetime.'".';
    }

    /**
     * @param mixed $value
     * @return Error|null
     */
    public function check($value)
    {
        $compare = $this->compare($value, $this->numberOrDateTime);

        $valid = $this->inclusive ? ($compare || ($value == $this->numberOrDateTime)) : $compare;

        if (!$valid){
            return $this->getError();
        }

        return null;
    }

    /**
     * @param int|float|DateTime $value
     * @param int|float|DateTime $scope
     * @return bool
     */
    protected abstract function compare($value, $scope);

    /**
     * @return string
     */
    protected abstract function getDirection();
}