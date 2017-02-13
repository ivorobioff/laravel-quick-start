<?php
namespace ImmediateSolutions\Support\Api\Searchable\Resolvers;
use ImmediateSolutions\Support\Core\Criteria\Day;
use ImmediateSolutions\Support\Validation\Rules\Moment;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class DayResolver
{
	/**
	 * @param string $date
	 * @return bool
	 */
	public function isProcessable($date)
	{
		return !(new Moment('Y-m-d'))->check($date);
	}

	/**
	 * @param string $date
	 * @return Day
	 */
	public function resolve($date)
	{
		return new Day($date);
	}
}