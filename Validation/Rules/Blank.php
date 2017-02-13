<?php
namespace ImmediateSolutions\Support\Validation\Rules;

use ImmediateSolutions\Support\Validation\Error;
use Countable;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Blank extends AbstractRule
{
	public function __construct()
	{
		$this->setIdentifier('empty');
		$this->setMessage('The value must not be empty string or array and must not contain only spaces.');
	}

	/**
	 * @param mixed $value
	 * @return Error|null
	 */
	public function check($value)
	{
		if (is_string($value) && trim($value) === ''){
			return $this->getError();
		}

		if ((is_array($value) || $value instanceof  Countable) && count($value) === 0){
			return $this->getError();
		}

		return null;
	}
}