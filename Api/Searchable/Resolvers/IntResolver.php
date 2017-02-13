<?php
namespace ImmediateSolutions\Support\Api\Searchable\Resolvers;
use ImmediateSolutions\Support\Validation\Rules\IntegerCast;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class IntResolver
{
	/**
	 * @param string $value
	 * @return int
	 */
	public function isProcessable($value)
	{
		return !(new IntegerCast(true))->check($value);
	}

	/**
	 * @param string $value
	 * @return int
	 */
	public function resolve($value)
	{
		return (int) $value;
	}
}