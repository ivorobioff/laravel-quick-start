<?php
namespace ImmediateSolutions\Support\Validation\Rules;

use ImmediateSolutions\Support\Validation\Error;
use ImmediateSolutions\Support\Validation\Value;
use DateTime;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Moment extends AbstractRule
{
    /**
     * @var string
     */
    private $format;

    /**
     * @param string $format
     */
    public function __construct($format = DateTime::ATOM)
    {
        $this->format = $format;

        $this->setIdentifier('datetime');
        $this->setMessage('The value must be a valid datetime string.');
    }

    /**
     * @param mixed|Value $value
     * @return Error|null
     */
    public function check($value)
    {
        $datetime = new DateTime();

        $formatted = $datetime->createFromFormat($this->format, $value);

        if (!$formatted || $formatted->format($this->format) != $value)
        {
            return $this->getError();
        }

        return null;
    }
}