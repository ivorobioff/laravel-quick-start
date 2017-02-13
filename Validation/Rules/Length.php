<?php
namespace ImmediateSolutions\Support\Validation\Rules;

use ImmediateSolutions\Support\Validation\Error;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Length extends AbstractRule
{
    /**
     * @var int
     */
    private $min;

    /**
     * @var int
     */
    private $max;

	/**
	 * @var string
	 */
	private $encoding;

    /**
     * @param int $min
     * @param int $max
     */
    public function __construct($min, $max = null)
    {
        $this->min = $min;
        $this->max = $max;

        $postfix = '.';

        if ($max){
            $postfix = ' and less (or equal) than '.$max.'.';
        }

        $this->setMessage('The string length must be greater than (or equal) '.$min.$postfix);

        $this->setIdentifier('length');
    }

	/**
	 * @param $encoding
	 * @return $this
	 */
	public function setEncoding($encoding)
	{
		$this->encoding = $encoding;
		return $this;
	}

    /**
     * @param mixed $value
     * @return Error|null
     */
    public function check($value)
    {
		if ($this->encoding){
			$length = mb_strlen($value, $this->encoding);
		} else {
			$length = mb_strlen($value);
		}

		if ($length < $this->min){
			return $this->getError();
		}

		if ($this->max && $length > $this->max){
			return $this->getError();
		}

        return null;
    }
}