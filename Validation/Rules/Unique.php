<?php
namespace ImmediateSolutions\Support\Validation\Rules;

use ImmediateSolutions\Support\Validation\Error;
use Traversable;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class Unique extends AbstractRule
{
	public function __construct()
	{
		$this->setIdentifier('unique');
		$this->setMessage('The values in the collection must be unique.');
	}

	/**
	 * @param array|Traversable $collection
	 * @return Error|null
	 */
	public function check($collection)
	{
		$values = [];

		foreach ($collection as $value){
			if (in_array($value, $values, true)){
				return $this->getError();
			}

			$values[] = $value;
		}

		return null;
	}
}