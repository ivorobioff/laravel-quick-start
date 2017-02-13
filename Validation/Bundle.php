<?php
namespace ImmediateSolutions\Support\Validation;

use IteratorAggregate;
use ArrayIterator;
use Countable;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Bundle implements IteratorAggregate, Countable
{
	/**
	 * @var array
	 */
	private $properties = [];

	/**
	 * @var string
	 */
	private $name;

	/**
	 * @var callable
	 */
	private $constraint;

	/**
	 * @var bool
	 */
	private $ignoreSoftness = false;

	/**
	 * @var callable
	 */
	private $source;

	/**
	 * @param string $name
	 * @param array $properties
	 */
	public function __construct($name, array $properties)
	{
		$this->name = $name;

		foreach ($properties as $key => $value){
			if (is_int($key)){
				$force = new Force(Force::REQUIRED);
				$property = $value;
			} else {
				$force = new Force($value);
				$property = $key;
			}

			$this->properties[] = [$property, $force];
		}
	}

	/**
	 * @param callable $callback
	 * @return $this
	 */
	public function when(callable $callback)
	{
		$this->constraint = $callback;
		return $this;
	}

	/**
	 * @return callable
	 */
	public function getConstraint()
	{
		return $this->constraint;
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @return ArrayIterator
	 */
	public function getIterator()
	{
		return new ArrayIterator($this->properties);
	}

	/**
	 * @return int
	 */
	public function count()
	{
		return count($this->properties);
	}

	/**
	 * @param bool $flag
	 */
	public function always($flag)
	{
		$this->ignoreSoftness = $flag;
	}

	/**
	 * @return bool
	 */
	public function ignoreSoftness()
	{
		return $this->ignoreSoftness;
	}

	/**
	 * @param callable $callback
	 * @return $this
	 */
	public function source(callable $callback)
	{
		$this->source = $callback;
		return $this;
	}

	/**
	 * @return callable
	 */
	public function getSource()
	{
		return $this->source;
	}
}