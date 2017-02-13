<?php
namespace ImmediateSolutions\Support\Validation\Rules;

use ImmediateSolutions\Support\Validation\Error;
use Traversable;

/**
 * The rule walks through the provided collection and applies to each item the rule provided by the factory callback
 *
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Each extends AbstractRule
{
	/**
	 * @var callable
	 */
	private $factory;

	/**
	 * @param callable $factory
	 */
	public function __construct(callable $factory)
	{
		$this->factory = $factory;
		$this->setIdentifier('collection');
		$this->setMessage('The collection is incorrect.');
	}

	/**
	 * @param array|Traversable $traversable
	 * @return bool
	 */
	public function check($traversable)
	{
		if ($error = $this->preCheck($traversable)){
			return $error;
		}

		$valid = true;

		foreach ($traversable as $key => $value){
			$error = call_user_func($this->factory)->check($value);

			if ($error){
				$valid = false;
				$this->getError()->addExtra($key, $error);
			}
		}

		if (!$valid){
			return $this->getError();
		}

		return null;
	}

	/**
	 * @param $traversable
	 * @return Error
	 */
	protected function preCheck($traversable)
	{
		if (!is_array($traversable) && !$traversable instanceof Traversable){
			return $this->setMessage('The collection is invalid.')->getError();
		}

		return null;
	}
}