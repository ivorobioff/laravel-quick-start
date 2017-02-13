<?php
namespace ImmediateSolutions\Support\Validation\Rules;

use ImmediateSolutions\Support\Validation\Error;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Walk extends Each
{
	public function __construct(callable $inflator)
	{
		parent::__construct(function() use ($inflator){
			return new Composite($inflator);
		});
	}

	/**
	 * @param $traversable
	 * @return Error
	 */
	protected function preCheck($traversable)
	{
		$message = 'The collection must be an array where values must be either arrays or objects.';

		if ($error = parent::preCheck($traversable)){
			return $this->setMessage($message)->getError();
		}

		$counter = 0;

		foreach ($traversable as $key => $value){
			if ($key != $counter || (!is_array($value) && !is_object($value))){
				return $this->setMessage($message)->getError();
			}

			$counter ++;
		}

		return null;
	}
}